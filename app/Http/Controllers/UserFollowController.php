<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Topics;
use App\Models\UserApps;
use DB;
use Carbon\Carbon;
use App\Models\UserTopics;

class UserFollowController extends Controller
{

    public function index(Request $req)
    {
        $topic = Topics::find($req->topic_id);

        return view('pages.userFollow.user_follow_topic', [
            'category_name' => 'user_follow',
            'page_name' => 'User Follow Topic',
            'has_scrollspy' => 0,
            'scrollspy_offset' =>'',
            'data'   => $topic,
        ]);
    }

    public function getList(Request $req)
    {
        $columns = array(
            // datatable column index  => database column name
            0 => 'user_id',
            1 => 'username',
            2 => 'real_name',
            3 => 'country_code',
            4 => 'created_at'
        );

        $userTopic = "SELECT C.user_id,C.username,C.real_name,C.country_code,A.created_at FROM user_topics A
        JOIN topics B ON B.topic_id = A.topic_id 
        JOIN users C ON C.user_id = A.user_id 
        WHERE A.topic_id = " . $req->topic_id . " 
        GROUP BY C.user_id,C.username,C.real_name,C.country_code,A.created_at";

        $data = DB::SELECT($userTopic);
        $total = count($data);
        if ($req->order[0]['column'] == 'user_id') {
            $userTopic .= " ORDER BY username asc LIMIT $req->length OFFSET $req->start ";
        } else {
            $userTopic .= " ORDER BY " . $columns[$req->order[0]['column']] . " " . $req->order[0]['dir'] . " LIMIT $req->length OFFSET $req->start ";
        }
        $dataLimit = DB::SELECT($userTopic);
        return response()->json([
            'draw'            => $req->draw,
            'recordsTotal'    => $total,
            "recordsFiltered" => $total,
            'data'            => $dataLimit,
        ]);
    }
    //     $detailTopic = Topics::find($req->topic_id);
    //     if($detailTopic == null){
    //         return response()->json([
    //             'success'=>false,
    //             'message'=>'Data Topic Not Found'
    //         ]);
    //     }
    //     else{
    //         $html = view('pages.userFollow.user_follow_topic',
    //         ['category_name' => 'user_follow',
    //         'page_name' => 'User Follow Topic',
    //         'has_scrollspy' => 1,
    //         'scrollspy_offset' => '',
    //         'detail_topic'=>$detailTopic])->render();

    //         return response()->json([
    //             'success'=>true,
    //             'html'=>$html
    //         ]);
    //     }
    // }
    public function userFollowDetail(Request $req)
    {

        $user = UserApps::find($req->user_id);
        if ($req->type == 'FOLLOWERS') {
            $type = "FOLLOWERS";
            $title = "User Followers";
        } else {
            $type = "FOLLOWING";
            $title = "User Following";

        }

        return view('pages.userFollow.user_follow_user', [
            'category_name' => 'user_follow',
            'page_name' => 'User Follow user ',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',
            'type' => $type,
            'title' => $title,
            'data'   => $user,
        ]);
    }

    public function getUserFollowList(Request $req)
    {
        $columns = array(
            // datatable column index  => database column name
            0 => 'user_id',
            1 => 'username',
            2 => 'real_name',
            3 => 'country_code',
        );


        if ($req->type == 'FOLLOWERS') {
            $userFollow = "SELECT B.user_id,B.username,B.real_name,B.country_code FROM user_follow_user A
            JOIN users B ON A.user_id_followed = B.user_id
            where user_id_follower = '" . $req->user_id . "'  
            GROUP BY B.user_id,B.username,B.real_name,B.country_code";
        } else {
            $userFollow = "SELECT B.user_id,B.username,B.real_name,B.country_code FROM user_follow_user A
            JOIN users B ON A.user_id_follower = B.user_id
            where user_id_followed = '" . $req->user_id . "'  
            GROUP BY B.user_id,B.username,B.real_name,B.country_code";
        }


        $data = DB::SELECT($userFollow);
        $total = count($data);
        if ($req->order[0]['column'] == 'user_id') {
            $userFollow .= " ORDER BY username asc LIMIT $req->length OFFSET $req->start ";
        } else {
            $userFollow .= " ORDER BY " . $columns[$req->order[0]['column']] . " " . $req->order[0]['dir'] . " LIMIT $req->length OFFSET $req->start ";
        }
        $dataLimit = DB::SELECT($userFollow);
        return response()->json([
            'draw'            => $req->draw,
            'recordsTotal'    => $total,
            "recordsFiltered" => $total,
            'data'            => $dataLimit,
        ]);
    }
}
