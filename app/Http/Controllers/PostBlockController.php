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

        // $activities = $feed->getActivities(0, 25)['results'];

        // return $activities;

        // $data = [];

        // while (count($data) >= 10) {
        //     # code...
        // }

        // $ids = [
        //     'd59fc522-8c52-4f26-a8f9-58e3034e1fee',
        //     '57c7dd68-9836-4ac7-9b7a-38d10c7165ac',
        //     '74e090a4-4020-48b6-8136-f334b750d9b4',
        //     'a3c59170-c110-4fac-929e-7834f6c6827f'
        // ];

        // // $query_params = ["ids" => join(',', $ids)];
        // // return $query_params;

        // return $client->getActivities($ids, null, true);


        // $foreign_id_times = null;
        // $enrich = true;
        // $reactions = [
        //     'own',
        //     'recent',
        //     'counts',
        //     'kinds'
        // ];

        // return response()->json([
        //     'draw'            => 0,
        //     'recordsTotal'    => 0,
        //     "recordsFiltered" => 0,
        //     'data'            => $result,
        // ]);

        // return $this->getFeeds();
        $users = UserApps::all();


        return view('pages.postBlock.post-block', [
            'category_name' => 'post-block',
            'page_name' => 'Post Block',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',
            'users' => $users,
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
