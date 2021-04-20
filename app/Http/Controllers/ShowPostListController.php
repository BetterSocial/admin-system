<?php

namespace App\Http\Controllers;

use App\Models\UserApps;
use GetStream\Stream\Client;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ShowPostListController extends Controller
{
    public function index(Request $req)
    {

        $user = UserApps::where('user_id',$req->user_id)->first();

//        Log::debug($req);
//        Log::debug("MASHOQ");
//        Log::debug($req->user_id);
        Log::debug("dayototoaoao");
        Log::debug($user);

        return view('pages.userPost.show_post_list', [
            'category_name' => 'user_post',
            'page_name' => 'show_post_list',
            'has_scrollspy' => 0,
            'scrollspy_offset' =>'',
            'data'   => $user,
        ]);

    }

    public function getData(Request $req) {

        Log::debug($req);
        Log::debug("MASHOQ");

        $client = new Client(env("GET_STREAM_KEY"), env("GET_STREAM_SECRET"));

        $feed = $client->feed('main_feed', $req->user_id);
//        $feed = $client->feed('main_feed', '8a84f60a-745d-4d34-993c-463c1d526ee0');
//        $feed = $client->feed('main_feed', '259cdb63-c21f-4015-8fa7-b1e53420a072');

        $response = $feed->getActivities();

        $result=  $response["results"];

        return response()->json([
            'draw'            => $req->draw,
            'recordsTotal'    => 0,
            "recordsFiltered" => 0,
            'data'            => $result,
        ]);





    }
}
