<?php

namespace App\Services;


use Illuminate\Support\Facades\Http;

class QueueService
{
    private $baseUrl;
    private $client;
    public function __construct()
    {
        $this->baseUrl = env('QUEUE_URL') . '/api/v1/user';
        $this->client = Http::withBasicAuth('betteruser', 'betterpassword')
            ->withHeaders([
                'Content-Type' => 'application/json',
            ]);
    }

    public function blockUser($userId)
    {
        $response =   $this->client
            ->post($this->baseUrl . '/admin-block-user', [
                'userId' => $userId,
            ]);
        return  $response->json();
    }
    public function unBlockUser($userId)
    {
        $response = $this->client
            ->post($this->baseUrl . '/admin-unblock-user', [
                'userId' => $userId,
            ]);
        return $response->json();
    }
}
