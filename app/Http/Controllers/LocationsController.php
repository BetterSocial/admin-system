<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Locations;
use DB;

class LocationsController extends Controller
{

    public function getData(Request $req){

        
        $columns = array(
            // datatable column index  => database column name
            0 => 'location_id',
            1 => 'zip',
            2 => 'neighborhood',
            3 => 'city',
            4 => 'state',
            5 => 'country',
            6 => 'location_level',
            7 => 'status',
            8 => 'slug_name',
        );
        $location = "SELECT location_id,zip,neighborhood,city,state,country,location_level,status,slug_name,created_at FROM location WHERE true";
//        if($req->name !=null){
//            $topic .= " AND name ILIKE '%$req->name%'";
//        }
//        if($req->category !=null){
//            $topic .= " AND categories ILIKE '%$req->category%'";
//        }


        $data = DB::SELECT($location);
        $total = count($data);
        if ($req->draw == 1) {
            $location .= " ORDER BY created_at ASC LIMIT $req->length OFFSET $req->start ";
        } else {
            $location .= " ORDER BY " . $columns[$req->order[0]['column']] . " " . $req->order[0]['dir'] . " LIMIT $req->length OFFSET $req->start ";
        }
        $dataLimit = DB::SELECT($location);
        return response()->json([
            'draw'            => $req->draw,
            'recordsTotal'    => $total,
            "recordsFiltered" => $total,
            'data'            => $dataLimit,
        ]);
    }

}
