<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GetStream\Stream\Client;

class PostController extends Controller
{
    //

    public function postHide(Request $request, $id)
    {
        $client = new Client(env('GET_STREAM_KEY'), env('GET_STREAM_SECRET'));
        $payload = [
            [
                'id' => $id,
                "set" => ["is_hide" => $request->is_hide]
            ]
        ];
        $status = $client->batchPartialActivityUpdate($payload);
        return $status;
    }

    public function deleteComment($id)
    {
        try {
            //code...
            $client = new Client(env('GET_STREAM_KEY'), env('GET_STREAM_SECRET'));
            $client->reactions()->delete($id);
            return $this->successResponse('success delete comment');
        } catch (\Throwable $th) {
            //throw $th;
            return $this->errorResponse('error delete comment ' . $th->getMessage());
        }
    }
}
