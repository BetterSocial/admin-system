<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserApps;
use Illuminate\Http\Request;
use FeedManager;
use GetStream\Stream\Client;

class PostBlockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $users = UserApps::all();
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
            throw $th;
        }
    }


    private function getFeeds()
    {
        $offset = 0;
        $data = [];
        $client = new Client("hqfuwk78kb3n", "pgx8b6zy3dcwnbz43jw7t2e8pmhesjn24zwxesx8cbmphvhpnvbejakrxbwzb75x");
        $options = [];
        $feed = $client->feed('user', "bettersocial");

        $response = $feed->getActivities($offset, 15, $options, $enrich = true);
        $data =  $response["results"];
        // while ($data <= 10) {
        //     $offset++;
        // }
        return $data;
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
}
