<?php

namespace App\Jobs;

use App\Entities\PostEntity;
use App\Models\LogModel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class CreatePostJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(private PostEntity $postEntity, private $apiKey)
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        try {
            //code...

            $posts[] = $this->postEntity->getPost();
            $baseUrl = config('constants.user_api') . '/api/v1/admin/bulk-post';
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'api-key' => $this->apiKey,
            ])->post($baseUrl, [
                'post' => $posts,
            ]);

            if ($response->ok()) {
                LogModel::createLog('upload-csv', 'upload success');
            } else {
                LogModel::createLog('upload-csv', 'upload csv fail ' . $response);
            }
        } catch (\Throwable $th) {
            LogModel::createLog('upload-csv', $th->getMessage());
            //throw $th;
        }
    }
}
