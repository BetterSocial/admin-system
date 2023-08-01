<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use RealRashid\SweetAlert\Facades\Alert;

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


    protected function successResponseWithAlert($message = 'success save data', $targetUrl = null)
    {

        Alert::success('success', $message);
        if ($targetUrl != null) {
            return redirect(route($targetUrl));
        }
        return redirect()->back();
    }

    protected function progressResponseWithAlert($message = 'In progress', $targetUrl = null)
    {

        Alert::info('Info', $message);
        if ($targetUrl != null) {
            return redirect(route($targetUrl));
        }
        return redirect()->back();
    }

    protected function errorResponseWithAlert($message = 'success save data', $param = null, $targetUrl = null)
    {
        Alert::error('Error', $message);
        if ($targetUrl == null) {
            return redirect()->back();
        }
        return redirect(route($targetUrl, $param));
    }


    protected function successDataTableResponse($draw, $recordsTotal, $recordsFiltered, $data)
    {
        return response()->json([
            'draw' => (int) $draw,
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            'data' => $data,
        ], 200);
    }


    protected function errorDataTableResponse()
    {
        return response()->json([
            'draw' => 0,
            'recordsTotal' => 0,
            'recordsFiltered' => 0,
            'data' => null,
        ], 200);
    }
}
