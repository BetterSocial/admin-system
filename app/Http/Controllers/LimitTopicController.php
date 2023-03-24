<?php

namespace App\Http\Controllers;

use App\Models\LimitTopic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LimitTopicController extends Controller
{
    //

    public function getData(Request $request)
    {
        try {
            $data = LimitTopic::latest()->first();
            if (!$data) {
                $data = 0;
            } else {
                $data = $data->limit;
            }
            return $this->successResponse('success get limit topic', [
                'limit' => $data
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            return $this->errorResponse($th->getMessage());
        }
    }

    public function create(Request $request)
    {
        try {
            DB::beginTransaction();
            LimitTopic::create($request->all());
            DB::commit();
            return $this->successResponse('success');
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return $this->errorResponse($th->getMessage());
        }
    }
}
