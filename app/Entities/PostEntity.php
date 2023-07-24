<?php

namespace App\Entities;

class PostEntity
{

    public function __construct(
        private $userId,
        private $anonimity,
        private $durationFeed,
        private $feedGroup,
        private $location,
        private $locationId,
        private $message,
        private $object,
        private $privacy,
        private $imagesUrl,
        private $topics,
        private $verb,
    ) {
    }

    public function getVerb()
    {
        return $this->verb;
    }

    public function toJson()
    {
        // Membuat array asosiatif berdasarkan properti objek
        $data = [
            'userId' => $this->userId,
            'anonimity' => $this->anonimity,
            'duration_feed' => $this->durationFeed,
            'feedGroup' => $this->feedGroup,
            'location' => $this->location,
            'location_id' => $this->locationId,
            'message' => $this->message,
            'object' => $this->object,
            'privacy' => $this->privacy,
            'images_url' => $this->imagesUrl,
            'topics' => $this->topics,
            'verb' => $this->verb,
        ];

        // Mengonversi array asosiatif ke format JSON
        return json_encode($data);
    }

    public function getPost()
    {
        return [
            'userId' => $this->userId,
            'anonimity' => $this->anonimity,
            'duration_feed' => $this->durationFeed,
            'feedGroup' => $this->feedGroup,
            'location' => $this->location,
            'location_id' => $this->locationId,
            'message' => $this->message,
            'object' => $this->object,
            'privacy' => $this->privacy,
            'images_url' => $this->imagesUrl,
            'topics' => $this->topics,
            'verb' => $this->verb,
        ];
    }
}
