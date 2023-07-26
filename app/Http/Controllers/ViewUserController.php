<?php

namespace App\Http\Controllers;

use App\Models\UserApps;
use App\Models\UserFollowUserModel;
use App\Services\FeedGetStreamService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use GetStream\StreamChat\Client as StreamClient;

class ViewUserController extends Controller
{

    private StreamClient $client;

    public function __construct()
    {
        $this->client =  new StreamClient(env('GET_STREAM_KEY'), env('GET_STREAM_SECRET'));
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = [
            'category_name' => 'viewUsers',
            'page_name' => 'view Users',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',

        ];
        // $pageName = 'widgets';
        return view('pages.users.user')->with($data);
    }

    private function getStreamClient(): StreamClient
    {
        $client = $this->client;
        return $client;
    }


    private function getChannelByUserId(String $userId, StreamClient $client)
    {

        // $filter = json_decode('{"members":{"$in":["57c7dd68-9836-4ac7-9b7a-38d10c7165ac"]}}', true);
        $filter = ['members' => ['$in' => ['57c7dd68-9836-4ac7-9b7a-38d10c7165ac']]];
        $sort = json_decode('[{"last_message_at":-1}]', true);
        return $client->queryChannels($filter);
    }

    private function removeMember(String $userId)
    {
        $client = $this->getStreamClient();
        $channel =  $client->Channel("#SupportthePolice", "topic_SupportthePolice");
        return $channel;
    }


    public function bannedUser(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'user_id' => 'required|string',
            ]);
            // ambil userId yang mau di banned;
            $userId = $request->input('user_id');
        } catch (\Throwable $th) {
            //throw $th;
        }
        // ambil semua channel message yang mengandung userId tersebut
        // keluarkan userId tersebut dari channel tersebut
    }
}
