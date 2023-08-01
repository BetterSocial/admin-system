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
            $posts[] = $this->postEntity->getPost();
            $baseUrl = config('constants.user_api') . '/api/v1/admin/bulk-post';
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'api-key' => $this->apiKey,
            ])->post($baseUrl, [
                'post' => $posts,
            ]);

            if ($response->ok()) {
                $body = $response->json();
                LogModel::createLog('upload-csv', json_encode($body));
            } else {
                LogModel::createLog('fail-upload-csv', $this->postEntity->toJson());
            }
        } catch (\Throwable $th) {
            LogModel::createLog('fail-upload-csv', $th->getMessage());
        }
    }
}
