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

    private $feed;

    public function __construct(FeedGetStreamService $feedService)
    {
        $this->feedService = $feedService;
    }


    private $posts;


    private $columns = array(
        0 => '',
        1 => '',
        2 => '',
        3 => '',
        4 => '',
        5 => '',
        6 => "count_upvotes",
        7 => 'count_downvotes',
        8 => 'total_block',
        9 => '',
        10 => 'time',
        11 => '',
    );

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
                    ->get()
                    ->pluck('getstream_activity_id');
                $comments = UserPostComment::where('comment', 'ilike', '%' . $message . '%')
                    ->get()
                    ->pluck('post_id');

                $activityIds = $posts->concat($comments)->unique()->values();
                if (count($activityIds) == 0) {
                    return $this->errorDataTableResponse();
                }
            }

            $dataTable = dataTableRequestHandle($req);
            $data = $this->getFeeds($dataTable['start'], $dataTable['length'], $activityIds);
            $data = $this->handleSort($data, $dataTable);
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


    private function handleSort($data, $sortingData)
    {
        $sortBy = $this->columns[$sortingData['column']] ?? null;
        $sortDirection = $sortingData['direction'] ?? 'asc';

        // Pastikan kolom yang digunakan untuk pengurutan adalah valid
        if (!$sortBy || !in_array($sortBy, $this->columns)) {
            return $data;
        }

        usort($data, function ($a, $b) use ($sortBy, $sortDirection) {
            if ($a[$sortBy] == $b[$sortBy]) {
                return 0;
            }
            return ($sortDirection == 'asc' ?
                $this->sortAsc($a, $b, $sortBy)
                : $this->sortDesc($a, $b, $sortBy));
        });

        return $data;
    }

    private function sortAsc($a, $b, $sortBy)
    {
        return ($a[$sortBy] < $b[$sortBy] ? -1 : 1);
    }

    private function sortDesc($a, $b, $sortBy)
    {
        return ($a[$sortBy] > $b[$sortBy] ? -1 : 1);
    }



    private function getFeeds($offset = 0, $limit = 10, $searchId = [])
    {
        try {
            $this->posts = $this->getPostsByBlockedUser();
            $this->feed =  $this->initializeFeed();
            $data = $this->fetchDataFromFeed($searchId, $offset, $limit);

            return $this->handlePoll($data);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    private function initializeFeed()
    {
        $client = new Client(env('GET_STREAM_KEY'), env('GET_STREAM_SECRET'));
        return $client->feed('user', "bettersocial");
    }

    private function fetchDataFromFeed($searchId, $offset, $limit)
    {
        $isSearch = count($searchId) >= 1;
        $options = [
            'own' => true,
            'recent' => true,
            'counts' => true,
            'counts',
            'kinds',
            'reactions.recent' => true,
        ];
        $data = [];

        if ($isSearch) {
            foreach ($searchId as $value) {
                $options['id_lte'] = $value;
                $response = $this->getFeedActivities(0, 1, $options);
                if (count($response["results"]) >= 1) {
                    $data[] = $response["results"][0];
                }
            }
        } else {
            $response = $this->getFeedActivities($offset, $limit, $options);
            $data = $response["results"];
        }

        return $data;
    }

    private function getFeedActivities($offset, $limit, $options)
    {
        return $this->feed->getActivities($offset, $limit, $options, true, $options);
    }

    private function handlePoll($data)
    {

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
            $latestReactions = $value['latest_reactions'];

            if (isset($latestReactions['upvotes'])) {
                $upvotesCount = count($latestReactions['upvotes']);
                $value['count_upvotes'] = $upvotesCount;
            } else {
                $value['count_upvotes'] = 0;
            }
            if (isset($latestReactions['downvotes'])) {
                $downvotesCount = count($latestReactions['downvotes']);
                $value['count_downvotes'] = $downvotesCount;
            } else {
                $value['count_downvotes'] = 0;
            }

            $withSortDescData[] = $value;
        }
        usort($withSortDescData, function ($a, $b) {
            return $a['total_block'] < $b['total_block'];
        });
        return $withSortDescData;
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
