<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use GetStream\Stream\Client;
use Illuminate\Support\Facades\Auth;

class SampleGetStream extends Controller
{
    public function index(){

        Log::debug(" MASHOQ TEST GET STREAM ");

        $client = new Client(env("GET_STREAM_KEY"), env("GET_STREAM_SECRET"));

//        $feed = $client->feed('main_feed', '8A84F60A-745D-4D34-993C-463C1D526EE0');
        $feed = $client->feed('main_feed', '8a84f60a-745d-4d34-993c-463c1d526ee0');

        $response = $feed->getActivities();



//        $feed4 = $client->feed('main_feed', '');




        Log::info(print_r($feed, true));

        Log::debug("\n\n ===========feed=========== \n\n");

        Log::info(print_r($response, true));

        Log::debug("\n\n ===========3=========== \n\n");

//        Log::info(print_r($feed3, true));

//        $user = Auth::user();
//        Log::debug($user->getAuthIdentifierName());
//        Log::debug($user->id);
//        Log::debug($user->password);
//        Log::debug($user->getAuthPassword());


//        return redirect('test_getStream');

    }
}
