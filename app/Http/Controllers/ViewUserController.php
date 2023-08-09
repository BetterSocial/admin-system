<?php

namespace App\Http\Controllers;

use App\Models\PostScoreModel;
use App\Models\UserApps;
use App\Models\UserFollowUserModel;
use App\Models\UserScoreModel;
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
        // $query = UserApps::select(
        //     'username',
        //     'user_id',
        //     'username',
        //     'country_code',
        //     'created_at'
        // );

        // $users = $query->get();
        // $userIds = $users->pluck('user_id')->toArray();
        // $userScores = UserScoreModel::whereIn('_id', $userIds)->get();

        // foreach ($userScores as  $userScore) {
        //     foreach ($users as $user) {
        //         if ($user->user_id = $userScore->_id) {
        //             $user->user_score = $userScore;
        //         }
        //     }
        // }

        // $query = UserApps::select(
        //     'username',
        //     'user_id',
        //     'country_code',
        //     'created_at'
        // );


        // $users = $query->get();
        // $userIds = $users->pluck('user_id')->toArray();
        // $userScores = UserScoreModel::whereIn('_id', $userIds)->get();

        // $userScoreMap = []; // Array associative untuk menyimpan user_score berdasarkan user_id

        // foreach ($userScores as $userScore) {
        //     $userScoreMap[$userScore->_id] = $userScore;
        // }

        // foreach ($users as $user) {
        //     if (isset($userScoreMap[$user->user_id])) {
        //         $userScore = $userScoreMap[$user->user_id];
        //         $user->user_score = $userScore;
        //     }
        // }

        // return $this->successResponse('success', $users);
        $data = [
            'category_name' => 'viewUsers',
            'page_name' => 'view Users',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',

        ];
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
