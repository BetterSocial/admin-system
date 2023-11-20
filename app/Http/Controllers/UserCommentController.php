<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserApps;
use App\Models\UserPostComment;
use Illuminate\Http\Request;

class UserCommentController extends Controller
{
    public function index(Request $request)
    {
        $userId = $request->input('user_id');
        $user = UserApps::find($userId);
        $data = [
            'category_name' => 'userComment',
            'page_name' => 'userComment',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',
            'user' => $user,

        ];
        return view('pages.users.comment', $data);
    }

    public function getData(Request $request)
    {
        try {
            $request->validate([
                'user_id' => 'required|string',
            ]);
            return UserPostComment::data($request);
        } catch (\Throwable $th) {
            return $this->errorDataTableResponse();
        }
    }
}
