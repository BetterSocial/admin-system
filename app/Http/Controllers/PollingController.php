<?php

namespace App\Http\Controllers;

use App\Models\UserApps;
use GetStream\Stream\Client;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Polling;
use App\Models\PollingOption;
use App\Models\LogPolling;
use DB;

class PollingController extends Controller
{
    
    public function getData(Request $req) {
        \Log::debug($req->all());
        $columns = array(
            // datatable column index  => database column name
                0 => 'A.polling_id',
                1 => 'A.question',
                2 => 'B.username',
                3 => 'A.created_at',
                4 => 'A.updated_at'
            );
        $polling = "SELECT A.polling_id,A.question, B.username,A.created_at,A.updated_at FROM polling A 
        JOIN users B ON A.user_id = B.user_id WHERE true";
        if($req->question !=null){
            $polling .= " AND A.quesiton ILIKE '%$req->question%'";
        }    
        if($req->username !=null){
            $polling .= " AND B.username ='".$req->username."'";
        }        

        $data = DB::SELECT($polling);
        $total = count($data);
        
        $polling .= " ORDER BY " . $columns[$req->order[0]['column']] . " " . $req->order[0]['dir'] . " LIMIT $req->length OFFSET $req->start ";
        //$polling .= " ORDER BY A.created_at DESC LIMIT $req->length OFFSET $req->start ";
       
        $dataLimit = DB::SELECT($polling);
        return response()->json([
            'draw'            => $req->draw,
            'recordsTotal'    => $total,
            "recordsFiltered" => $total,
            'data'            => $dataLimit,
        ]);

    }

    public function pollingDetail(Request $req){

        $polling = DB::table('polling')
        ->join('users', 'users.user_id', '=', 'polling.user_id')
        ->select('polling.polling_id', 'polling.question', 'users.username')->first();

        $query = "SELECT A.polling_id,A.question, B.username FROM polling A 
        JOIN users B ON A.user_id = B.user_id WHERE A.polling_id = '".$req->polling_id."'";
        $dataOption = PollingOption::WHERE('polling_id',$req->polling_id)->get();
        //$polling = DB::SELECT($query);

        //Log::Debug($polling);
        return view('pages.polling.polling_detail', [
            'category_name' => 'polling',
            'page_name' => 'Polling Detail',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',
            'data'   => $polling,
            'dataOption' =>$dataOption
        ]);
    }
}
