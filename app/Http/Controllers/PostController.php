<?php

namespace App\Http\Controllers;

use App\Http\Requests\UploadRequest;
use App\Models\ApiKey;
use App\Models\LogModel;
use App\Models\UserApps;
use App\Services\ApiKeyService;
use ErrorException;
use Exception;
use Illuminate\Http\Request;
use GetStream\Stream\Client;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use League\Csv\Reader;
use Throwable;

class PostController extends Controller
{
    const CSV_MIMES = ['csv', 'txt'];

    private $apiKeyService;

    public function __construct(ApiKeyService $apiKeyService)
    {
        $this->apiKeyService = $apiKeyService;
    }

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
            ], [
                'csv_file' => 'required csv file'
            ]);
            $file = $request->file('csv_file')->getRealPath();
            $csv = Reader::createFromPath($file, 'r');
            $csv->setHeaderOffset(0);

            $posts = [];
            foreach ($csv as $record) {
                $this->validateRecord($record);

                $images = [];
                $topics = [];
                if ($record['images_url']) {
                    $images = explode(",", $record['images_url']);
                }
                if ($record['topics']) {
                    $topics = explode(",", $record['topics']);
                }

                $userId = $record['user_id'];
                $user = UserApps::find($userId);
                if (!$user) {
                    throw new \Exception('User not found');
                }
                $post = [
                    'userId' => $userId,
                    'anonimity' => filter_var($record['anonimity'], FILTER_VALIDATE_BOOLEAN),
                    'duration_feed' => $record['duration_feed'],
                    'feedGroup' => $record['feed_group'],
                    'location' => $record['location'],
                    'location_id' => $record['location_id'],
                    'message' => $record['message'],
                    'object' => $record['object'],
                    'privacy' => $record['privacy'],
                    'images_url' => $images,
                    'topics' => $topics,
                    'verb' => $record['verb'],
                ];

                $posts[] = $post;
            }

            dd('ok');
            $baseUrl = config('constants.user_api') . '/api/v1/admin/bulk-post';
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'api-key' => $this->apiKeyService->getKey(),
            ])->post($baseUrl, [
                'post' => $posts,
            ]);

            if ($response->ok()) {
                LogModel::insertLog('upload-csv', 'upload csv success');
                return $this->successResponseWithAlert('Success created post');
            } else {
                LogModel::insertLog('upload-csv', 'upload csv fail');
                return $this->errorResponseWithAlert('Failed Create post');
            }
        } catch (Throwable $th) {
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

    private function validateRecord($record)
    {
        $rules = [
            'user_id' => 'required',
            'anonimity' => 'required',
            'duration_feed' => 'required',
            'feed_group' => 'required',
            'location' => 'required',
            'message' => 'required',
            'privacy' => 'required',
            'verb' => 'required',
        ];

        $messages = [
            'user_id.required' => 'User ID is required',
            'anonimity.required' => 'Anonimity is required',
            'duration_feed.required' => 'Duration feed is required',
            'feed_group.required' => 'Feed Group is required',
            'location.required' => 'Location is required',
            'message.required' => 'Message is required',
            'privacy.required' => 'Message is required',
            'verb.required' => 'Verb is required',
        ];

        $validator = Validator::make($record, $rules, $messages);

        if ($validator->fails()) {
            throw new Exception($validator->errors());
        }
    }
}
