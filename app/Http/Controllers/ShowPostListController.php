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
//        Log::debug($user);

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

        $client = new Client(config('constant.get_stream_key'), config('constant.get_stream_secret'));

        $feed = $client->feed('main_feed', $req->user_id);

        $response = $feed->getActivities($req->start, $req->length);

        $result=  $response["results"];

        return response()->json([
            'draw'            => $req->draw,
            'recordsTotal'    => 0,
            "recordsFiltered" => 0,
            'data'            => $result,
        ]);
    }
}
