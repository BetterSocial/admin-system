<?php


namespace App\Services;

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

    public function getFeeds($userId)
    {
        $feed = $this->client->feed('user_excl', $userId);

        $response = $feed->getActivities(0, 30);

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
            $yesterday = Carbon::yesterday();
            $now = new DateTime('now');
            $expireTime = $yesterday->toIso8601String();
            $feeds = $this->getFeeds($userId);
            $activities = [];
            foreach ($feeds as $key => $value) {

                $time = $now->format(DateTime::ISO8601);
                $uuid = Uuid::uuid4();
                // $activity = [
                //     'actor' => $value['actor'],
                //     'verb' => $value['verb'],
                //     'object' => $value['object'],
                //     'time' => $time,
                //     'foreign_id' => $uuid,
                //     'expired_at' => $expireTime,
                // ];
                $value['expired_at'] = $expireTime;
                // $value['foreign_id'] = $uuid;

                $activities[] = $value;
                // $feed = $this->client->feed('user_excl', $userId);
                // $feed->updateActivityToTargets(Uuid::uuid4(), $time, [], [], ["user_excl:" . $userId]);
                $set = [
                    "expired_at" => $expireTime,
                ];
                $unset = [];
                $this->client->doPartialActivityUpdate($value['id'], null, null, $set, $unset);
            }
            // return $this->client->updateActivities($activities);
            return $activities;
            return $this->getFeeds($userId);
            //code...
        } catch (\Throwable $th) {
            //throw $th;
            return false;
        }
    }
}
