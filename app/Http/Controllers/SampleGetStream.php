<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use GetStream\Stream\Client;

class SampleGetStream extends Controller
{
    public function index(){

        Log::debug(" MASHOQ TEST GET STREAM ");

        $client = new Client(env("GET_STREAM_KEY"), env("GET_STREAM_SECRET"));

        $feed = $client->feed('main_feed', '8A84F60A-745D-4D34-993C-463C1D526EE0');

//        $feed2 = $client->feed('main_feed', 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1c2VyX2lkIjoiOEE4NEY2MEEtNzQ1RC00RDM0LTk5M0MtNDYzQzFENTI2RUUwIiwiZXhwIjoxNjE3OTYyODAzfQ.2rKCI5y4GBpDpe48GUdgW__aMGecxe5aSUadVTUpRUY');

//        $feed3 = $client->feed('main_feed', 'eyJ1c2VyX2lkIjoiOEE4NEY2MEEtNzQ1RC00RDM0LTk5M0MtNDYzQzFENTI2RUUwIiwiZXhwIjoxNjE3OTYyODAzfQ');

//        $feed4 = $client->feed('main_feed', '');


//        Log::debug($feed);

        Log::info(print_r($feed, true));

        Log::debug("\n\n ===========2=========== \n\n");

//        Log::info(print_r($feed2, true));

        Log::debug("\n\n ===========3=========== \n\n");

//        Log::info(print_r($feed3, true));


//        return redirect('test_getStream');

    }
}
