<?php

namespace App\Services;

use App\Models\ApiKey;

class ApiKeyService
{

    public function __construct()
    {
    }

    public function getKey()
    {
        $apiKey = ApiKey::latest()->first();

        if (!$apiKey) {
            $apiKey = ApiKey::create([
                'key' => $this->generateApiKey()
            ]);
        }
        return $apiKey->key;
    }


    private function generateApiKey()
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $apiKey = '';
        for ($i = 0; $i < 10; $i++) {
            $apiKey .= $characters[rand(0, $charactersLength - 1)];
        }
        return $apiKey;
    }
}
