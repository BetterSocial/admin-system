<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use GetStream\Stream\Client;
use Illuminate\Support\Facades\Auth;

class SampleGetStream extends Controller
{
    public function index(){

        Log::debug(" MASHOQQQ TEST GET STREAM ");

        $client = new Client(env("GET_STREAM_KEY"), env("GET_STREAM_SECRET"));

//        $feed = $client->feed('main_feed', '8A84F60A-745D-4D34-993C-463C1D526EE0');
        $feed = $client->feed('main_feed', '8a84f60a-745d-4d34-993c-463c1d526ee0');

        $response = $feed->getActivities();
        $response2 = json_encode($feed->getActivities());

        $single_resp = $feed->getActivities(6); //['result']



//        Log::debug($response2["results"]);
//        Log::debug($response->results[0]);

        $result=  $response["results"];

        Log::debug(print_r($result, true));












//        $feed4 = $client->feed('main_feed', '');




//        Log::info(print_r($feed, true));
//
        Log::debug("\n\n ===========feed=========== \n\n");
//
        Log::info(print_r($response, true));

        Log::debug("\n\n ===========single=========== \n\n");

//        Log::info(print_r($single_resp, true));

//        Log::info(print_r($total, true));

//        Log::info(print_r($feed3, true));

//        $user = Auth::user();
//        Log::debug($user->getAuthIdentifierName());
//        Log::debug($user->id);
//        Log::debug($user->password);
//        Log::debug($user->getAuthPassword());


//        return redirect('test_getStream');

    }
}
