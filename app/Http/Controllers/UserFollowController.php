<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Topics;
use App\Models\UserApps;
use Carbon\Carbon;
use App\Models\UserTopics;
use Illuminate\Support\Facades\DB;

class UserFollowController extends Controller
{

    public function index(Request $req)
    {
        $topic = Topics::find($req->topic_id);

        return view('pages.userFollow.user_follow_topic', [
            'category_name' => 'user_follow',
            'page_name' => 'User Follow Topic',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',
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

        $userTopic .= " ORDER BY " . $columns[$req->order[0]['column']] . " " . $req->order[0]['dir'] . " LIMIT $req->length OFFSET $req->start ";

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
            'page_name' => 'User Follow user',
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
            0 => 'user_id',
            1 => 'username',
            2 => 'real_name',
            3 => 'country_code',
        );

        $userFollow = DB::table('user_follow_user')
            ->select('B.user_id', 'B.username', 'B.real_name', 'B.country_code')
            ->join('users as B', function ($join) use ($req) {
                if ($req->type == 'FOLLOWERS') {
                    $join->on('user_follow_user.user_id_follower', '=', 'B.user_id');
                } else {
                    $join->on('user_follow_user.user_id_followed', '=', 'B.user_id');
                }
            });

        // Menambahkan kondisi WHERE
        if ($req->type == 'FOLLOWERS') {
            $userFollow->where('user_follow_user.user_id_followed', $req->user_id);
        } else {
            $userFollow->where('user_follow_user.user_id_follower', $req->user_id);
        }

        // Menghitung total data tanpa paginasi
        $total = $userFollow->count();

        // Handle sorting and pagination
        $columnIdx = $req->order[0]['column'];
        $columnName = $columns[$columnIdx];
        $columnDir = $req->order[0]['dir'];

        $userFollow = $userFollow
            ->groupBy('B.user_id', 'B.username', 'B.real_name', 'B.country_code')
            ->orderBy($columnName, $columnDir)
            ->skip($req->start)
            ->take($req->length)
            ->get();

        return response()->json([
            'draw'            => $req->draw,
            'recordsTotal'    => $total,
            "recordsFiltered" => $total,
            'data'            => $userFollow,
        ]);
    }
}
