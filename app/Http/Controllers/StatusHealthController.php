<?php

namespace App\Http\Controllers;

class StatusHealthController extends Controller
{
    public function live()
    {
        return response()->noContent(200);
    }
}
