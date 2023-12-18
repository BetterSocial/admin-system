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

    public function getChannel($channelType, $channelId)
    {
        return $this->client->Channel($channelType, $channelId);
    }

    public function updateChannel($channelType, $channelId, $data)
    {
        $channel = $this->client->Channel($channelType, $channelId);
        $channel->update($data);
    }

    // get message by id
}
