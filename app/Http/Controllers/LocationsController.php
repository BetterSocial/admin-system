<?php

namespace App\Http\Controllers;


use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Locations;
use App\Models\LogModel;
use Illuminate\Support\Facades\Log;
use phpDocumentor\Reflection\Location;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LocationsController extends Controller
{

    public function getData(Request $req)
    {


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
        $location = "SELECT location_id,zip,neighborhood,city,state,country,location_level,status,slug_name,created_at,location_level as location_icon,flg_show FROM location WHERE true";

        //        Log::debug($req->all());
        if ($req->neighborhood != null) {
            $location .= " AND neighborhood ILIKE '%$req->neighborhood%'";
        }
        if ($req->city != null) {
            $location .= " AND city ILIKE '%$req->city%'";
        }
        if ($req->state != null) {
            $location .= " AND state ILIKE '%$req->state%'";
        }
        if ($req->country != null) {
            $location .= " AND country ILIKE '%$req->country%'";
        }


        $data = DB::SELECT($location);
        $total = count($data);

        $location .= " ORDER BY " . $columns[$req->order[0]['column']] . " " . $req->order[0]['dir'] . " LIMIT $req->length OFFSET $req->start ";

        $dataLimit = DB::SELECT($location);
        Log::debug($dataLimit);
        return response()->json([
            'draw'            => $req->draw,
            'recordsTotal'    => $total,
            "recordsFiltered" => $total,
            'data'            => $dataLimit,
        ]);
    }

    public function addLocations(Request $req)
    {
        //        $file = $req->file('file');

        //        $this->validate($req, [
        //            'file' => 'image|max:1024|dimensions:min_width=64,min_height=64',
        //
        //        ]);
        $country = ucfirst($req->country);
        $state = ucfirst($req->state);
        $city = ucfirst($req->city);
        $neighborhood = ucfirst($req->neighborhood);
        $zip = ucfirst($req->zip);
        $location_level = ucfirst($req->location_level);
        $slug_name = '';
        $status = 'Y';

        //TODO benerin validasi
        $check = DB::table('location')->where([
            ['country', '=', $country],
            ['state', '=', $state],
            ['city', '=', $city],
            ['neighborhood', '=', $neighborhood],
            ['zip', '=', $zip]
        ])->count();
        if ($check > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Data location  already exists'
            ]);
        }


        Locations::create([
            'country' => $country,
            'state' => $state,
            'city' => $city,
            'neighborhood' => $neighborhood,
            'zip' => $zip,
            'location_level' => $location_level,
            'slug_name' => $slug_name,
            'status' => $status,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
        LogModel::insertLog('add-location', 'success add new location');
        return response()->json([
            'success' => true,
        ]);
    }


    public function showLocation(Request $req)
    {
        try {
            $user = Auth::user();
            $roles = $user->roles->pluck('name')->first();
            if ($roles == 'viewer') {
                return response()->json([
                    'success' => false,
                    'message' => "You not have an access"
                ]);
            } else {
                $data = Locations::find($req->location_id);
                if ($data != null) {
                    if ($data->flg_show == 'Y') {
                        $data->flg_show = 'N';
                    } else {
                        $data->flg_show = 'Y';
                    }
                    $data->save();
                    return response()->json([
                        'success' => true,
                    ]);
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => "Data Location Not Found"
                    ]);
                }
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
}
