<?php

namespace App\Entities;

class PostEntityBuilder
{
    private $userId;
    private $anonimity;
    private $durationFeed;
    private $feedGroup;
    private $location;
    private $locationId;
    private $message;
    private $object;
    private $privacy;
    private $imagesUrl;
    private $topics;
    private $verb;

    public function setUserId($userId)
    {
        $this->userId = $userId;
        return $this;
    }

    public function setAnonimity($anonimity)
    {
        $this->anonimity = $anonimity;
        return $this;
    }

    public function setDurationFeed($durationFeed)
    {
        $this->durationFeed = $durationFeed;
        return $this;
    }

    public function setFeedGroup($feedGroup)
    {
        $this->feedGroup = $feedGroup;
        return $this;
    }

    public function setLocation($location)
    {
        $this->location = $location;
        return $this;
    }

    public function setLocationId($locationId)
    {
        $this->locationId = $locationId;
        return $this;
    }

    public function setMessage($message)
    {
        $this->message = $message;
        return $this;
    }

    public function setObject($object)
    {
        $this->object = $object;
        return $this;
    }

    public function setPrivacy($privacy)
    {
        $this->privacy = $privacy;
        return $this;
    }

    public function setImagesUrl($imagesUrl)
    {
        $this->imagesUrl = $imagesUrl;
        return $this;
    }

    public function setTopics($topics)
    {
        $this->topics = $topics;
        return $this;
    }

    public function setVerb($verb)
    {
        $this->verb = $verb;
        return $this;
    }

    public function build()
    {
        return new PostEntity(
            $this->userId,
            $this->anonimity,
            $this->durationFeed,
            $this->feedGroup,
            $this->location,
            $this->locationId,
            $this->message,
            $this->object,
            $this->privacy,
            $this->imagesUrl,
            $this->topics,
            $this->verb
        );
    }
}
