<?php

namespace App\Http\Controllers;

use App\Models\LogModel;
use App\Models\Polling;
use App\Models\PollingOption;
use App\Models\PostModel;
use App\Models\PostTopic;
use App\Models\UserApps;
use App\Models\UserBlockedUser;
use App\Models\UserPostComment;
use App\Services\FeedGetStreamService;
use Illuminate\Http\Request;
use GetStream\Stream\Client;
use Illuminate\Support\Facades\DB;

use function PHPUnit\Framework\returnSelf;

class PostBlockController extends Controller
{

    private FeedGetStreamService $feedService;

    public function __construct(FeedGetStreamService $feedService)
    {
        $this->feedService = $feedService;
        $this->posts = $this->getPostsByBlockedUser();
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
            $dataTable = dataTableRequestHandle($req);
            if ($message) {
                $posts = PostModel::where('getstream_activity_id', $message)
                    ->orWhere('post_content', 'ilike', '%' . $message . '%')
                    ->whereNotNull('getstream_activity_id')
                    ->get()
                    ->pluck('getstream_activity_id');
                $comments = UserPostComment::where('comment', 'ilike', '%' . $message . '%')
                    ->get()
                    ->pluck('post_id');
                $postIds = PostTopic::filterSearchName($message)
                    ->get()
                    ->pluck('post_id');
                $postsFromTopic = PostModel::whereIn('post_id', $postIds)
                    ->whereNotNull('getstream_activity_id')
                    ->get()
                    ->pluck('getstream_activity_id');

                $activityIds = $posts->concat($comments)->merge($postsFromTopic)->unique()->values();
                if (count($activityIds) == 0) {
                    return $this->errorDataTableResponse();
                }
                $direction = $dataTable['direction'] ?? 'asc';
                $activityIdsArray = $activityIds->toArray();

                if ($direction === 'asc') {
                    sort($activityIdsArray);
                } elseif ($direction === 'desc') {
                    rsort($activityIdsArray);
                }

                $activityIds = collect($activityIdsArray);
            }

            $data = $this->getFeeds($dataTable['start'], $dataTable['length'], $activityIds);
            $dataAfterSort = $this->handleSort($data, $dataTable);
            return response()->json([
                'draw' => $draw,
                'data' => $dataAfterSort ?? [],
            ]);
        } catch (\Throwable $th) {
            return $this->errorDataTableResponse();
        }
    }

    private function handleSort($data, $sortingData)
    {
        $sortBy = $this->columns[$sortingData['column']] ?? null;
        $sortDirection = $sortingData['direction'] ?? 'asc';

        if (!$sortBy || !in_array($sortBy, $this->columns)) {
            return $data;
        }

        // Convert null values to 0 for sorting
        foreach ($data as &$item) {
            if (!isset($item['count_upvotes'])) {
                $item['count_upvotes'] = 0;
            }
            if (!isset($item['count_downvotes'])) {
                $item['count_downvotes'] = 0;
            }
        }

        if ($sortDirection == 'asc') {
            return collect($data)->sortBy($sortBy)->values()->all();
        } else {
            return collect($data)->sortByDesc($sortBy)->values()->all();
        }
    }



    private function getFeeds($offset = 0, $limit = 10, $searchId = [])
    {
        $data = $this->fetchDataFromFeed($searchId, $offset, $limit);
        return $this->handlePoll($data);
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
            $searchId = $searchId->toArray();
            $searchId = array_slice($searchId, $offset, $limit);
            foreach ($searchId as $value) {
                try {
                    $options['id_lte'] = $value;
                    $response = $this->getFeedActivities(0, 1, $options);
                    if (count($response["results"]) >= 1) {
                        $data[] = $response["results"][0];
                    }
                } catch (\Throwable $th) {
                    continue;
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
        return $this->feedService->getActivities($offset, $limit, $options);
    }

    private function handlePoll($data)
    {
        $withSortDescData = [];
        foreach ($data as $value) {
            $userId = $value['actor']['id'];
            $user = UserApps::select('user_id', 'blocked_by_admin')->where('user_id', $userId)->first();
            $value['user'] = $user ?? null;

            if ($value['verb'] == 'poll') {
                $value['poll'] = $this->getPoll($value['polling_id']);
                $value['polling_options'] = $this->getPollOption($value['polling_id']);
            }

            // Ensure total_block is always initialized
            $value['total_block'] = 0;
            foreach ($this->posts as $post) {
                if ($post->post_id == $value['id']) {
                    $value['total_block'] = $post->total_block;
                }
            }

            $latestReactions = $value['reaction_counts'] ?? [];
            $value['count_upvotes'] = isset($latestReactions['upvotes']) ? $latestReactions['upvotes'] : 0;
            $value['count_downvotes'] = isset($latestReactions['downvotes']) ? $latestReactions['downvotes'] : 0;

            $withSortDescData[] = $value;
        }
        return collect($withSortDescData)->sortByDesc('total_block')->values()->all();
    }



    public function updateFeed(Request $request, $id)
    {
        $client = new Client(config('constants.get_stream_key'), config('constants.get_stream_secret'));
        $payload = [
            [
                'id' => $id,
                "set" => ["is_hide" => $request->is_hide]
            ]
        ];
        $client->batchPartialActivityUpdate($payload);
        LogModel::insertLog('update-feed', 'success update feed');
        return $payload;
    }



    public function getPostsByBlockedUser()
    {
        return  UserBlockedUser::select('post_id')
            ->selectRaw('count(*) as total_block')
            ->where('post_id', '!=', null)
            ->groupBy('post_id')
            ->orderByDesc('total_block', 'desc')
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
        foreach ($pollingOptions as $value) {
            $options[] = $value->option ?? '';
        }
        return $options;
    }
}
