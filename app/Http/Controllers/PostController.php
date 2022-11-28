<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GetStream\Stream\Client;

class PostController extends Controller
{
    //

    public function postHide(Request $request, $id)
    {
        $client = new Client("hqfuwk78kb3n", "pgx8b6zy3dcwnbz43jw7t2e8pmhesjn24zwxesx8cbmphvhpnvbejakrxbwzb75x");
        $payload = [
            [
                'id' => $id,
                "set" => ["is_deleted" => $request->is_deleted]
            ]
        ];
        $status = $client->batchPartialActivityUpdate($payload);
        return $status;
    }
}
