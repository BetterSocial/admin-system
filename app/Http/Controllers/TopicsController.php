<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Topics;
use DB;
use Carbon\Carbon;
use Exception;

class TopicsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function getData(Request $req)
    {
        \Log::debug($req->all());
        \Log::debug($req->order[0]['column']);
        $columns = array(
            // datatable column index  => database column name
                0 => 'topic_id',
                1 => 'name',
                2 => 'icon_path',
                3 => 'categories',
                4 => 'created_at',
                5 => 'flg_show'
            );
        $topic = "SELECT topic_id,name,icon_path,categories,created_at,'location',flg_show FROM topics WHERE true";
        if($req->name !=null){
            $topic .= " AND name ILIKE '%$req->name%'";
        }     
        if($req->category !=null){
            $topic .= " AND categories ILIKE '%$req->category%'";
        }        
        
        

        $data = DB::SELECT($topic);
        $total = count($data);
        if ($req->order[0]['column'] == 'topic_id') {
            $topic .= " ORDER BY created_at ASC LIMIT $req->length OFFSET $req->start ";
        } else {
            $topic .= " ORDER BY " . $columns[$req->order[0]['column']] . " " . $req->order[0]['dir'] . " LIMIT $req->length OFFSET $req->start ";
        }
        $dataLimit = DB::SELECT($topic);
        return response()->json([
            'draw'            => $req->draw,
            'recordsTotal'    => $total,
            "recordsFiltered" => $total,
            'data'            => $dataLimit,
        ]);
     }

     public function addTopics(Request $req){

        try {
            $file = $req->file('file');
            
            $this->validate($req, [
                'file' => 'image|max:1024|dimensions:min_width=64,min_height=64',
            
            ]);
            $name = ucfirst($req->name);
            $category = ucfirst($req->category);
            $check = DB::table('topics')->where([['name','=',$name],['categories','=',$category]])->count();
            \Log::debug($check);

            if($check > 0){
                return response()->json([
                    'success' => false,
                    'message' => 'Data topic with name '.$name.' and category '.$category.' already exists'
                ]);
            }

            $response =  $req->file->storeOnCloudinary('icons')->getSecurePath();
            
            Topics::create([
                'icon_path' =>$response,
                'name' =>$name,
                'categories'=>$category,
                'created_at'=>Carbon::now()
            ]);
            return response()->json([
                'success' => true,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success'=> false,
                'message'=>$e->getMessage()
            ]);
        }
     }
     
     public function showTopics(Request $req){
        try {
		 	
            $data = Topics::find($req->topic_id);
            if($data !=null){
                if($data->flg_show == 'Y'){
                    $data->flg_show = 'N';
                }
                else{
                    $data->flg_show = 'Y';
                    
                }
                $data->save();
                return response()->json([
                    'success'=> true,
                ]);
            }
            else{
                return response()->json([
                    'success'=> false,
                    'message'=> "Data Topic Not Found"
                ]);
            }
            
        } catch (Exception $e) {
            return response()->json([
                'success'=> false,
                'message'=>$e->getMessage()
            ]);
        }
     }
}
