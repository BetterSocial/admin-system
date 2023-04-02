<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GetStream\Stream\Client;
use Illuminate\Support\Facades\Http;
use League\Csv\Reader;


class PostController extends Controller
{
    //

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

        $request->validate([
            'csv_file' => 'required|mimes:csv,txt'
        ]);
        if ($request->hasFile('csv_file')) {
            $file = $request->file('csv_file')->getRealPath();

            $csv = Reader::createFromPath($file, 'r');
            $csv->setHeaderOffset(0); // jika CSV file memiliki header, atur offsetnya

            $data = [];

            foreach ($csv as $record) {
                // lakukan sesuatu dengan setiap baris record di sini
                // contoh: $record['column_name']
                $userId = $record['user_id'];
                $anonimity = $record['anonimity'];
                $durationFeed = $record['duration_feed'];
                $feedGroup = $record['feed_group'];
                $location = $record['location'];
                $locationId = $record['location_id'];
                $message = $record['message'];
                $object = $record['object'];
                $privacy = $record['privacy'];
                $images_url = $record['images_url'];
                $verb = $record['verb'];
                $topics = $record['topics'];
                $itemTopics = explode(",", $topics);

                // foreach ($itemTopics as $item) {
                //     dd($item);
                // }


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
                    "images_url" => $images_url,
                    "topics" => $itemTopics,
                    "verb" => $verb
                ];
                $data[] = $post;
            }

            $url = config('constants.user_api');
            $baseUrl = $url . '/api/v1/admin/bulk-post';
            $response = Http::send('POST', $baseUrl, [
                'headers' => [
                    'Content-Type' => 'application/json',
                ],
                'json' => $data,
            ]);

            if ($response->ok()) {
                // handling jika request berhasil
                $data = $response->json();
                return $this->successResponseWithAlert('success', $data);
            } else {
                // handling jika request gagal
                $status = $response->status();
                return $this->errorResponseWithAlert($status);
            }
        }
    }

    public function downloadTemplate(Request $request)
    {
        $file_path = public_path('post.csv');
        $headers = [
            'Content-Type' => 'text/csv',
        ];

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
        return $status;
    }

    public function deleteComment($id)
    {
        try {
            $client = new Client(env('GET_STREAM_KEY'), env('GET_STREAM_SECRET'));
            $client->reactions()->delete($id);
            return $this->successResponse('success delete comment');
        } catch (\Throwable $th) {
            return $this->errorResponse('error delete comment ' . $th->getMessage());
        }
    }
}
