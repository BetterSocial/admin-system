<?php

namespace App\Services;

use App\Models\UserApps;
use Error;
use Illuminate\Support\Facades\Http;

class UserServiceImpl implements UserService
{

    private ApiKeyService $apiKeyService;

    public function __construct(ApiKeyService $apiKeyService)
    {
        $this->apiKeyService = $apiKeyService;
    }

    public function getUserByAnonymousId($anonymousId)
    {
        try {

            $userAnonymous = UserApps::find($anonymousId);
            $encrypted = $userAnonymous->encrypted;
            $apiKey = $this->apiKeyService->getKey();
            $baseUrl = config('constants.user_api') . '/api/v1/admin/decrypt-anonymous-user';
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'api-key' => $apiKey,
            ])->post($baseUrl, [
                'encrypted_id' => $encrypted
            ]);

            $body = $response->json();
            if ($body['status'] == 'error') {
                throw new Error('User not found');
            }
            $data = $body['data'];
            $userId = $data['signed_user_id'];
            $user = UserApps::find($userId);
            return $user;
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }
}
