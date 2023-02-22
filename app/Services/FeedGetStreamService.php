<?php


namespace App\Services;

use Carbon\Carbon;
use GetStream\Stream\Client;

class FeedGetStreamService
{
    private $client;

    public function __construct()
    {
        $this->client = new Client(env('GET_STREAM_KEY'), env('GET_STREAM_SECRET'));
    }

    public function removeUser($userId)
    {
        $this->client->users()->delete($userId);
    }

    public function addUser($userId, $humanId, $pic, $username)
    {
        $this->client->users()->add($userId, [
            "created_at" => Carbon::now()->toISOString(),
            "human_id" => $humanId,
            "profile_pic_url" => $pic,
            "username" => $username
        ]);
    }
}
