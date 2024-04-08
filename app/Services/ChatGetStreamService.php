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
        try {
            $channel = $this->client->Channel($channelType, $channelId);
            $channel->update($data);
        } catch (\Throwable $th) {
            $status = json_decode($th->getMessage());
            if ($status->StatusCode == 404) {
                $data['channel_type'] = 3;
                $this->client->Channel($channelType, $channelId, $data)->create('bettersocial');
            }
        }
    }

    // get message by id
}
