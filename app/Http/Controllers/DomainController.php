<?php

namespace App\Http\Controllers;


use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Domain;
use DB;
use Illuminate\Support\Facades\Log;

class DomainController extends Controller
{
    public function getData(Request $req)
    {
        \Log::debug($req->all());
  
        $columns = array(
            // datatable column index  => database column name
                0 => 'domain_page_id',
                1 => 'domain_name',
                2 => 'logo',
                3 => 'short_description',
                4 => 'created_at',
                5 => 'updated_at'
            );
        $topic = "SELECT domain_page_id,domain_name,logo,short_description,created_at,'updated_at' FROM domain_page WHERE true";
        if($req->domainName !=null){
            $topic .= " AND domain_name ILIKE '%$req->domainName%'";
        }         
        

        $data = DB::SELECT($topic);
        $total = count($data);
        
        $topic .= " ORDER BY " . $columns[$req->order[0]['column']] . " " . $req->order[0]['dir'] . " LIMIT $req->length OFFSET $req->start ";
       
        $dataLimit = DB::SELECT($topic);
        return response()->json([
            'draw'            => $req->draw,
            'recordsTotal'    => $total,
            "recordsFiltered" => $total,
            'data'            => $dataLimit,
        ]);
     }

}