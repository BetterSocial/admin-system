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
        $file = $req->file('file');

        $this->validate($req, [
            'file' => 'image|max:1024|dimensions:min_width=64,min_height=64',
        
        ]);
        $response =  $req->file->storeOnCloudinary('icons')->getSecurePath();
        Topics::create([
            'icon_path' =>$response,
            'name' =>$req->name,
            'categories'=>$req->category,
            'created_at'=>Carbon::now()
        ]);
        return response()->json([
            'success' => true,
        ]);
     }
}
