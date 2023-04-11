<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CreateTopicController extends Controller
{
    //

    public function index(Request $request)
    {

        $data = [
            'category_name' => 'forms',
            'page_name' => 'create-topics',
            'has_scrollspy' => 1,
            'scrollspy_offset' => 100,

        ];
        return view('pages.topic.form_add_topics')->with($data);
    }
}
