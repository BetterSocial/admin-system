<?php


namespace App\Services;

use GetStream\Stream\Client;

class FeedGetStreamService
{
    private $client;

    public function __construct()
    {

        $this->client = new Client(env('GET_STREAM_KEY'), env('GET_STREAM_SECRET'));
    }
}
