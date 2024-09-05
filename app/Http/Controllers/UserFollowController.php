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
        $columns = [
            0 => 'user_id',
            1 => 'username',
            2 => 'country_code',
            3 => 'created_at',
            4 => 'is_anonymous',
        ];

        $orderColumn = $columns[$req->order[0]['column']] ?? 'created_at'; // Default order column
        $orderDirection = $req->order[0]['dir'] === 'asc' ? 'asc' : 'desc'; // Ensure valid order direction

        // Sanitize inputs
        $topicId = (int) $req->input('topic_id');
        $limit = (int) $req->input('length', 10);
        $offset = (int) $req->input('start', 0);

        // Query using Eloquent with relations
        $query = UserApps::select('user_id', 'username', 'country_code', 'created_at', 'is_anonymous')
            ->whereHas('userTopics', function ($query) use ($topicId) {
                $query->where('topic_id', $topicId);
            })
            ->with(['userTopics'])
            ->groupBy('user_id', 'username', 'country_code', 'created_at', 'is_anonymous');

        // Get total records before applying limit and offset
        $total = $query->count();

        // Apply ordering, limit, and offset
        $users = $query->orderBy($orderColumn, $orderDirection)
            ->limit($limit)
            ->offset($offset)
            ->get();

        return response()->json([
            'draw' => (int) $req->input('draw', 1),
            'recordsTotal' => $total,
            'recordsFiltered' => $total,
            'data' => $users,
        ]);
    }

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
