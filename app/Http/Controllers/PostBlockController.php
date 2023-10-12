<?php

namespace App\Http\Controllers;

use App\Models\LogModel;
use App\Models\Polling;
use App\Models\PollingOption;
use App\Models\PostModel;
use App\Models\UserPostComment;
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
        return view('pages.postBlock.post-block', [
            'category_name' => 'post-block',
            'page_name' => 'Post Block',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',
        ]);
    }

    public function data(Request $req)
    {
        try {
            $draw = (int) $req->input('draw', 0);
            $message = $req->input('message', null);
            $activityIds = [];
            if ($message) {
                $posts = PostModel::where('post_content', 'ilike', '%' . $message . '%')
                    ->whereNotNull('getstream_activity_id')
                    ->get();
                $activityIds = $posts->pluck('getstream_activity_id')->toArray();
                if (count($activityIds) == 0) {
                    return $this->errorDataTableResponse();
                }
            }

            $dataTable = dataTableRequestHandle($req);
            $data = $this->getFeeds($dataTable['start'], $dataTable['length'], $activityIds);
            return response()->json([
                'draw' => $draw,
                'recordsTotal' => count($activityIds) >= 1  ? count($activityIds) : $req->input('total', 100),
                'recordsFiltered' => count($activityIds) >= 1  ? count($activityIds) : $req->input('total', 100),
                'data' => $data ?? 0,
            ]);
        } catch (\Throwable $th) {
            return $this->errorDataTableResponse();
        }
    }


    private function getFeeds($offset = 0, $limit = 10, $searchId = [],)
    {

        try {
            $this->posts =  $this->getPostsByBlockedUser();
            $client = new Client(env('GET_STREAM_KEY'), env('GET_STREAM_SECRET'));
            $feed = $client->feed('user', "bettersocial");
            $data = [];
            if (count($searchId) >= 1) {
                foreach ($searchId as  $value) {
                    $options = [
                        'id_lte' => $value,
                        'own' => true,
                        'recent' => true,
                        'counts' => true,
                        'counts',
                        'kinds',
                        'reactions.recent' => true
                    ];
                    $response = $feed->getActivities(0, 1, $options, true, $options);
                    $data[] =  $response["results"][0];
                }
            } else {
                $options = [
                    'own' => true,
                    'recent' => true,
                    'counts' => true,
                    'counts',
                    'kinds',
                    'reactions.recent' => true
                ];
                $response = $feed->getActivities($offset, $limit, $options, true, $options);
                $data =  $response["results"];
            }

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
