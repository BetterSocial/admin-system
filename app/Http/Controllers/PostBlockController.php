<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserApps;
use App\Models\UserBlockedUser;
use Illuminate\Http\Request;
use FeedManager;
use GetStream\Stream\Client;
use Illuminate\Support\Facades\DB;
use PHPUnit\Framework\Constraint\Count;

class PostBlockController extends Controller
{

    private $posts;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // $users = UserApps::all();
        // return $this->getFeeds();
        // return $this->data($request);
        return view('pages.postBlock.post-block', [
            'category_name' => 'post-block',
            'page_name' => 'Post Block',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',
            // 'users' => $users,
        ]);
    }

    public function data(Request $request)
    {
        try {
            $data = $this->getFeeds();
            return $data;
        } catch (\Throwable $th) {
            throw $th->getMessage();
        }
    }


    private function getFeeds()
    {

        $this->posts =  $this->getPostsByBlockedUser();
        $offset = 0;
        $data = [];
        $client = new Client("hqfuwk78kb3n", "pgx8b6zy3dcwnbz43jw7t2e8pmhesjn24zwxesx8cbmphvhpnvbejakrxbwzb75x");
        $options = [];
        $feed = $client->feed('user', "bettersocial");

        $response = $feed->getActivities($offset, 15, $options, $enrich = true);
        $data =  $response["results"];
        $withSortDescData = [];
        foreach ($data as  $value) {
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
    }

    public function updateFeed(Request $request, $id)
    {
        $client = new Client("hqfuwk78kb3n", "pgx8b6zy3dcwnbz43jw7t2e8pmhesjn24zwxesx8cbmphvhpnvbejakrxbwzb75x");
        $payload = [
            [
                'id' => $id,
                "set" => ["is_hide" => $request->is_hide]
            ]
        ];
        $status = $client->batchPartialActivityUpdate($payload);
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
}
