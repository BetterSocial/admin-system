<?php

namespace App\Http\Controllers;

use App\Models\UserApps;
use App\Services\FeedGetStreamService;
use GetStream\Stream\Client;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ShowPostListController extends Controller
{
    public function index(Request $req)
    {

        $user = UserApps::where('user_id', $req->user_id)->first();

        $data = [
            'category_name' => 'user_post',
            'page_name' => 'show_post_list',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',
            'data'   => $user,
        ];

        return view('pages.userPost.show_post_list', $data);
    }

    public function getData(Request $req)
    {

        $feed = new FeedGetStreamService();
        $feeds = $feed->getFeeds($req->user_id);
        return response()->json([
            'draw'            => $req->draw,
            'recordsTotal'    => 0,
            "recordsFiltered" => 0,
            'data'            => $feeds,
        ]);
    }
}
