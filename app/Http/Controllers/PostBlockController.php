<?php

namespace App\Http\Controllers;

use App\Models\LogModel;
use App\Models\Polling;
use App\Models\PollingOption;
use App\Services\FeedGetStreamService;
use Illuminate\Http\Request;
use GetStream\Stream\Client;
use Illuminate\Support\Facades\DB;

class PostBlockController extends Controller
{

    private FeedGetStreamService $feedService;

    public function __construct(FeedGetStreamService $feedService)
    {
        $this->feedService = $feedService;
    }

    private $posts;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        return $this->feedService->getFeedByActivityId('53c1f4f1-f09e-11ed-9ee3-0e0d34fb440f');
        return view('pages.postBlock.post-block', [
            'category_name' => 'post-block',
            'page_name' => 'Post Block',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',
            // 'users' => $users,
        ]);
    }

    public function data(Request $req)
    {
        try {
            $draw = (int) $req->input('draw', 0);
            $searchName = $req->input('name');
            $searchCategory = $req->input('category');
            $orderColumnIndex = (int) $req->input('order.0.column');
            $orderDirection = $req->input('order.0.dir', 'asc');
            $start = (int) $req->input('start', 0);
            $length = (int) $req->input('length', 10);
            $data = $this->getFeeds($start, $length);
            return response()->json([
                'draw' => $draw,
                'recordsTotal' => $req->input('total', 100),
                'recordsFiltered' => $req->input('total', 100),
                'data' => $data,
            ]);
        } catch (\Throwable $th) {
            return $this->errorDataTableResponse();
        }
    }


    private function getFeeds($offset = 0, $limit = 10)
    {

        try {

            $this->posts =  $this->getPostsByBlockedUser();
            $data = [];
            $client = new Client(env('GET_STREAM_KEY'), env('GET_STREAM_SECRET'));
            $options = [
                'own' => true,
                'recent' => true,
                'counts' => true,
                'counts',
                'kinds',
                // 'reactions.recent' => true
            ];
            $feed = $client->feed('user', "bettersocial");
            $response = $feed->getActivities($offset, $limit, $options, $enrich = true, $options);
            $data =  $response["results"];


            $withSortDescData = [];
            foreach ($data as  $value) {
                if ($value['verb'] == 'poll') {
                    $value['poll'] = $this->getPoll($value['polling_id']);
                    $value['polling_options'] = $this->getPollOption($value['polling_id']);
                }
                $value['total_block'] = 0;
                foreach ($this->posts as $post) {
                    if ($post->post_id == $value['id']) {
                        $value['total_block'] = $post->total_block;
                    }
                }
                $withSortDescData[] = $value;
            }
            usort($withSortDescData, function ($a, $b) {
                return $a['total_block'] < $b['total_block'];
            });
            return $withSortDescData;
        } catch (\Throwable $th) {
            // file_put_contents('error.txt', $th->getMessage());
            throw $th;
        }
    }

    public function updateFeed(Request $request, $id)
    {
        $client = new Client(env('GET_STREAM_KEY'), env('GET_STREAM_SECRET'));
        $payload = [
            [
                'id' => $id,
                "set" => ["is_hide" => $request->is_hide]
            ]
        ];
        $status = $client->batchPartialActivityUpdate($payload);
        LogModel::insertLog('update-feed', 'success update feed');
        return $payload;
    }



    public function getPostsByBlockedUser()
    {
        return DB::table('user_blocked_user')
            ->selectRaw('post_id, count(*) as total_block')
            ->where('post_id', '!=', null)
            ->groupBy('post_id')
            ->orderBy('total_block', 'DESC')
            ->get();
    }

    private function getPoll($pollingId): string
    {
        $polling =  Polling::where('polling_id', $pollingId)->first();
        return $polling->question ?? '';
    }

    private function getPollOption($pollingId)
    {

        $pollingOptions = PollingOption::select('option')->where('polling_id', $pollingId)->get();
        $options = array();
        foreach ($pollingOptions as $key => $value) {
            $options[] = $value->option ?? '';
        }
        return $options;
    }
}
