<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Topics;
use DB;

class TopicsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

     public function getData(Request $req){

         \Log::debug($req);
        $topic = "SELECT topic_id,name,icon_path,categories,created_at,'location' FROM topics WHERE true";
        if($req->name !=null){
            $topic .= " AND name ILIKE '%$req->name%'";
        }     
        if($req->category !=null){
            $topic .= " AND categories ILIKE '%$req->category%'";
        }        
        

        $data = DB::SELECT($topic);
        $total = count($data);
        $topic .= " LIMIT $req->length OFFSET $req->start ";
        $data2 = DB::SELECT($topic);
        return response()->json([
            'draw'            => $req->draw,
            'recordsTotal'    => $total,
            "recordsFiltered" => $total,
            'data'            => $data2,
        ]);
     }
}
