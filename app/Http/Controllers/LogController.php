<?php

namespace App\Http\Controllers;

use App\Models\LogModel;
use App\Models\Logs;
use Illuminate\Http\Request;

class LogController extends Controller
{
    //

    public function data(Request $request)
    {
        $logs = LogModel::all();
        $data = [
            'category_name' => 'logs',
            'page_name' => 'logs',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',
            'logs' => $logs,

        ];
        return view('pages.log', $data);
    }
}
