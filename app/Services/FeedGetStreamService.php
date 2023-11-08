<?php


namespace App\Services;

use App\Models\UserApps;
use Carbon\Carbon;
use DateTime;
use GetStream\Stream\Client;
use Illuminate\Support\Facades\Date;
use Ramsey\Uuid\Uuid;


class FeedGetStreamService
{
    private Client $client;

    public function __construct()
    {
        $this->client = new Client(env('GET_STREAM_KEY'), env('GET_STREAM_SECRET'));
    }

    public function getFeedByActivityId($activityId)
    {

        $response =  $this->client->getActivities([$activityId]);
        $data =  $response["results"];
        return $data[0];
    }

    public function removeUser($userId)
    {
        $this->client->users()->delete($userId);
    }

    public function getFeeds($userId)
    {
        $feed = $this->client->feed('user_excl', $userId);

        $options = [
            'own' => true,
            'recent' => true,
            'counts' => true,
            'counts',
            'kinds',
            'reactions.recent' => true
        ];
        $response = $feed->getActivities(0, 30, $options, false, $options);

        $result =  $response["results"];
        return $result;
    }

    public function removeFeed($userId)
    {
        $yesterday = Carbon::yesterday();
        $time = $yesterday->toIso8601String();
        $this->client->feed('user_excl', $userId)->updateActivityToTargets("e585beb2-b4e7-11ed-a5a9-0e0d34fb440f", $time, [], [], []);
    }

    public function updateExpireFeed($userId)
    {
        $tatus = false;
        try {
            $now = new DateTime('now');
            $feeds = $this->getFeeds($userId);
            $activities = [];
            foreach ($feeds as $key => $value) {
                $time = $now->format(DateTime::ISO8601);
                $uuid = Uuid::uuid4();
                $date = Carbon::yesterday();
                $expireTime = $date->toISOString();
                $value['expired_at'] = $expireTime;

                $activities[] = $value;
                $set = [
                    "expired_at" => $expireTime,
                    "duration_feed" => "1",
                ];
                $unset = [];
                $this->client->doPartialActivityUpdate($value['id'], null, null, $set, $unset);
            }
            return $this->getFeeds($userId);
            //code...
        } catch (\Throwable $th) {
            //throw $th;
            return false;
        }
    }

    public function addUser($userId)
    {
        $userApp = UserApps::find($userId);
        return $this->client->users()->add($userApp->user_id, [
            "created_at" => Carbon::now()->toISOString(),
            "human_id" => $userApp->human_id,
            "profile_pic_url" => $userApp->profile_pic_path,
            "username" => $userApp->username
        ]);
    }

    public function upvote($activityId, $userId)
    {
        $this->client->reactions()->add('upvotes', $activityId, $userId, [
            'count_upvote' => 1,
            "text" => 'You have new upvote'
        ]);
    }

    public function downvote($activityId, $userId)
    {
        $this->client->reactions()->add('downvotes', $activityId, $userId, [
            'count_upvote' => 1,
            "text" => 'You have new downvote'
        ]);
    }

    public function removeUpvote($reactionId)
    {
        $this->client->reactions()->delete($reactionId);
    }

    public function getActivities($offset, $limit, $options)
    {

        $feed = $this->client->feed('user', "bettersocial");
        return $feed->getActivities($offset, $limit, $options, true, $options);
    }
}
