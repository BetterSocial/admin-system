<?php

namespace App\Http\Controllers;


use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Domain;
use DB;
use Illuminate\Support\Facades\Log;

class FormulaController extends Controller
{
    public function BenchmarkPostImpression($dur_min,$dur_marg,$words)
    {
        $value = $dur_min + $dur_marg * $words;
        return $value;
    }

    public function BenchmarkPostImpression1(Request $req)
    {
        $value =$req->dur_min + $req->dur_marg * $req->words;
        return $value;
    
    }

}