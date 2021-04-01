<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\UserApps;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;


class UsersAppController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function getData(Request $req){
        $columns = array(
            // datatable column index  => database column name
                0 =>'user_id',
                1 => 'username',
                2 => 'country_code',
                3 => 'created_at',
            );
        $user = "SELECT user_id,username,country_code,created_at,status FROM users WHERE true";
        if($req->username !=null){
            $user .= " AND username ILIKE '%$req->username%'";
        }     
        if($req->countryCode !=null){
            $user .= " AND country_code ILIKE '%$req->countryCode%'";
        }        
        
        

        $data = DB::SELECT($user);
        $total = count($data);
        if($req->draw == 1){
            $user .= " ORDER BY created_at asc LIMIT $req->length OFFSET $req->start ";

        }
        else{
            $user .= " ORDER BY " .$columns[$req->order[0]['column']]. " ".$req->order[0]['dir']." LIMIT $req->length OFFSET $req->start ";

        }
        $dataLimit = DB::SELECT($user);
        return response()->json([
            'draw'            => $req->draw,
            'recordsTotal'    => $total,
            "recordsFiltered" => $total,
            'data'            => $dataLimit,
        ]);
    }

    public function downloadCsv(Request $req){

        $user = "SELECT user_id,username,real_name,last_active_at,status,country_code,created_at FROM users WHERE true";
        if($req->username !=null){
            $user .= " AND username ILIKE '%$req->username%'";
        }     
        if($req->countryCode !=null){
            $user .= " AND country_code ILIKE '%$req->countryCode%'";
        }        
        
        

        $data = DB::SELECT($user);

        $filename = "Data User List-".md5(date("Y-m-d H:i:s")).'.csv';
        $path = Storage::path($filename);
        $headers = array(
            "Content-type" => "text/csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        );
        $file = fopen($path,'w');
        fputcsv($file,[
            '','','','','',
            "Data User List"
            ]
            ,";");
        //EMTER
        fputcsv($file,[],";");
        fputcsv($file,[ "Download Time :",Carbon::now()->toDateTimeString()],";");
        // fputcsv($file,[],"\t");
        // fputcsv($file,["\t","Download by :",SessionUtil::getUsername()],"\t");
        // fputcsv($file,["\t","Tanggal Download :",$this->formatDate(DateUtil::dateTimeNow(),'12')],"\t");
        fputcsv($file,[],";");
        fputcsv($file, [
            "Username",
            "Real Name",
            "Country Code",
            "Registered At",
            "Last Active",
            "Status"
        ],";");
        
        foreach ($data as $row=>$value){
            $body = [
                $value->username,
                $value->real_name,
                $value->country_code,
                Carbon::parse($value->created_at),
                Carbon::parse($value->last_active_at),
                $value->status,
            ];
            fputcsv($file,$body,";");
        }
        fclose($file);
        
        return response()->download($path,$filename,$headers);
    }

    public function userDetailView(Request $req){
        $user = UserApps::find($req->user_id);

        return view('pages.users.userDetail', [
            'category_name' => 'view_users',
            'page_name' => 'User Detail ',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',
            'data'   => $user,
        ]);
    }


    public function updateStatus(Request $req){
        $data = UserApps::find($req->user_id);
        if($data->status == 'Y'){
            $data->status = 'N';
        }
        else{
            $data->status = 'Y';
            
        }
        $data->save();
        return response()->json([
            'success'=> true,
        ]);
    }


   
}
