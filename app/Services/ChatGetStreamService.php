<?php


namespace App\Services;

use GetStream\StreamChat\Client as StreamClient;

class ChatGetStreamService
{
    private $client;

    public function __construct()
    {
        $this->client =  new StreamClient(env('GET_STREAM_KEY'), env('GET_STREAM_SECRET'));
    }

    public function deActiveUser($userId)
    {
        $this->client->deactivateUser($userId, [
            "mark_messages_deleted" => true,
        ]);
    }
}
