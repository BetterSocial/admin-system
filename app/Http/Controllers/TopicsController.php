<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Topics;
use DB;
use Carbon\Carbon;

class TopicsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

     public function getData(Request $req){

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
        $dataLimit = DB::SELECT($topic);
        return response()->json([
            'draw'            => $req->draw,
            'recordsTotal'    => $total,
            "recordsFiltered" => $total,
            'data'            => $dataLimit,
        ]);
     }

     public function addTopics(Request $req){
        \Log::debug($req);
        $file = $req->file('file');
        $location = 'storage/img';
    
        $file->move($location,$file->getClientOriginalName());
        Topics::create([
            'icon_path' =>$location.'/'.$file->getClientOriginalName(),
            'name' =>$req->name,
            'categories'=>$req->category,
            'created_at'=>Carbon::now()
        ]);
        return response()->json([
            'status' => true,
        ]);
     }
}
