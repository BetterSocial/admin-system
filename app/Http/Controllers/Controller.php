<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function successResponse($message = 'success get data', $data = [], $statusCode = 200)
    {
        $body = [
            'status' => 'success',
            'message' => $message,
            'data' => $data
        ];

        return response()->json($body, $statusCode);
    }

    protected function errorResponse($message = '', $statusCode = 500)
    {
        $body =  [
            'status' => 'error',
            'message' => $message
        ];

        return response()->json($body, $statusCode);
    }
}
