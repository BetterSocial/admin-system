<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Locations;
use DB;

class LocationsController extends Controller
{

    public function getData(Request $req){

        \Log::debug($req);
        \Log::debug("cobaaa ini [parameter]");
        $topic = "SELECT location_id,zip,neighborhood,city,state,country,location_level,status,slug_name FROM location WHERE true";
//        if($req->name !=null){
//            $topic .= " AND name ILIKE '%$req->name%'";
//        }
//        if($req->category !=null){
//            $topic .= " AND categories ILIKE '%$req->category%'";
//        }


        $data = DB::SELECT($topic);
        $total = count($data);
//        $topic .= " LIMIT $req->length OFFSET $req->start ";
        $data2 = DB::SELECT($topic);
        return response()->json([
            'draw'            => $req->draw,
            'recordsTotal'    => $total,
            "recordsFiltered" => $total,
            'data'            => $data2,
        ]);
    }

}
