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
  
        $columns = array(
            // datatable column index  => database column name
                1 => 'domain_page_id',
                2 => 'domain_name',
                3 => 'logo',
                4 => 'short_description',
                5 => 'created_at',
                6 => 'updated_at'
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

    public function formEdit(Request $req){
        $findDomain = Domain::find($req->domain_page_id);
      
        return view('pages.domain.add_logo_domain',[
            'category_name' => 'domain',
            'page_name' => 'add-logo-domain',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',
            'data' => $findDomain,
            
        ]);
    }

    public function saveLogo(Request $req){

        try {
            $file = $req->file('file');
            
            $this->validate($req, [
                'file' => 'image|max:1024|dimensions:min_width=64,min_height=64',
            
            ]);
            $findDomain =  Domain::find($req->id);

            if($findDomain->count() <= 0){
                return response()->json([
                    'success' => false,
                    'message' => 'Data topic not found'
                ]);
            }

            $response =  $req->file->storeOnCloudinary('domain-image')->getSecurePath();
            $findDomain->logo = $response;
            $findDomain->save();
           
            return response()->json([
                'success' => true,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success'=> false,
                'message'=>$e->getMessage()
            ]);
        }
       
    }

}