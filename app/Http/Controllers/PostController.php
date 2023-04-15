<?php

namespace App\Http\Controllers;

use App\Models\ApiKey;
use App\Models\LogModel;
use App\Models\UserApps;
use ErrorException;
use Illuminate\Http\Request;
use GetStream\Stream\Client;
use Illuminate\Support\Facades\Http;
use League\Csv\Reader;


class PostController extends Controller
{
    //

    function generateRandomString($length = 20)
    {
        $randomChars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';

        for ($i = 0; $i < $length; $i++) {
            // if ($i % 5 == 0 && $i > 0) {
            //     $randomString .= '-';
            // }
            $randomString .= $randomChars[rand(0, strlen($randomChars) - 1)];
        }

        return $randomString;
    }

    public function index(Request $request)
    {

        $data = [
            'category_name' => 'post',
            'page_name' => 'post',
            'has_scrollspy' => 0,
            'scrollspy_offset' => ''

        ];

        return view('pages.post.post', $data);
    }

    public function upload(Request $request)
    {

        try {
            $request->validate([
                'csv_file' => 'required|mimes:csv,txt'
            ]);
            if ($request->hasFile('csv_file')) {
                $file = $request->file('csv_file')->getRealPath();

                $csv = Reader::createFromPath($file, 'r');
                $csv->setHeaderOffset(0);

                $data = [];

                foreach ($csv as $record) {
                    $userId = $record['user_id'];
                    if (!$userId) throw new ErrorException('user_id is required');
                    // Check if user_id exists in the database
                    $user = UserApps::find($userId);
                    if (!$user) {
                        throw new \Exception('User not found');
                    }

                    $anonimity = $record['anonimity'];
                    if (!$anonimity) throw new ErrorException('anonimity is required');
                    $durationFeed = $record['duration_feed'];
                    if (!$durationFeed) throw new ErrorException('duration_feed is required');
                    $feedGroup = $record['feed_group'];
                    if (!$feedGroup) throw new ErrorException('feed_group is required');
                    $location = $record['location'];
                    if (!$location) throw new ErrorException('location is required');
                    $locationId = $record['location_id'];
                    $message = $record['message'];
                    if (!$message) throw new ErrorException('message is required');
                    $object = $record['object'];
                    $privacy = $record['privacy'];
                    if (!$privacy) throw new ErrorException('privacy is required');
                    $images_url = $record['images_url'];
                    $verb = $record['verb'];
                    if (!$verb) throw new ErrorException('verb is required');
                    $topics = $record['topics'];
                    if ($topics) {
                        $itemTopics = explode(",", $topics);
                    } else {
                        $itemTopics = [];
                    }


                    $anonimity = filter_var($anonimity, FILTER_VALIDATE_BOOLEAN);;
                    $images = [];
                    $post = [
                        'userId' => $userId,
                        'anonimity' => $anonimity,
                        "duration_feed" => $durationFeed,
                        "feedGroup" => $feedGroup,
                        "location" => $location,
                        "location_id" => $locationId,
                        "message" => $message,
                        "object" => $object,
                        "privacy" => $privacy,
                        "images_url" => $images,
                        "topics" => $itemTopics,
                        "verb" => $verb
                    ];
                    $data[] = $post;
                }

                $apiKey = ApiKey::latest()->first();

                if (!$apiKey) {
                    $apiKey = ApiKey::create([
                        'key' => $this->generateApiKey()
                    ]);
                }

                $url = config('constants.user_api');
                $baseUrl = $url . '/api/v1/admin/bulk-post';
                $response = Http::send('POST', $baseUrl, [
                    'headers' => [
                        'Content-Type' => 'application/json',
                        'api-key' => $apiKey->key,
                    ],
                    'json' => ['post' => $data],
                ]);

                if ($response->ok()) {
                    $data = $response->json();
                    LogModel::insertLog('upload-csv', 'upload csv success');
                    return $this->successResponseWithAlert('success created post');
                } else {
                    $status = $response->status();
                    $data = $response->json();
                    LogModel::insertLog('upload-csv', 'upload csv fail');
                    return $this->errorResponseWithAlert('Failed Create post');
                }
            }
        } catch (\Throwable $th) {
            //throw $th;
            LogModel::insertLog('upload-csv', $th->getMessage());
            return $this->errorResponseWithAlert($th->getMessage());
        }
    }

    public function downloadTemplate(Request $request)
    {
        $file_path = public_path('post.csv');
        $headers = [
            'Content-Type' => 'text/csv',
        ];

        LogModel::insertLog('download', 'download template csv');
        return response()->download($file_path, time() . '.csv', $headers);
    }

    public function postHide(Request $request, $id)
    {
        $client = new Client(env('GET_STREAM_KEY'), env('GET_STREAM_SECRET'));
        $payload = [
            [
                'id' => $id,
                "set" => ["is_hide" => $request->is_hide]
            ]
        ];
        $status = $client->batchPartialActivityUpdate($payload);
        LogModel::insertLog('post-hide', 'success post hide');
        return $status;
    }

    public function deleteComment($id)
    {
        try {
            $client = new Client(env('GET_STREAM_KEY'), env('GET_STREAM_SECRET'));
            $client->reactions()->delete($id);
            LogModel::insertLog('delete-comment', 'success delete comment');
            return $this->successResponse('success delete comment');
        } catch (\Throwable $th) {
            return $this->errorResponse('error delete comment ' . $th->getMessage());
        }
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
