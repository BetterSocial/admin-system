<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\UserApps;
use App\Services\ChatGetStreamService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use GetStream\Stream\Client;
use Illuminate\Support\Facades\DB;

class UsersAppController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function getData(Request $req)
    {
        $columns = array(
            // datatable column index  => database column name
            0 => 'user_id',
            1 => 'username',
            2 => 'country_code',
            3 => 'created_at',
        );
        $user = "SELECT user_id,username,country_code,created_at, is_banned FROM users WHERE true";
        if ($req->username != null) {
            $user .= " AND username ='" . $req->username . "'";
        }
        if ($req->countryCode != null) {
            $user .= " AND country_code ='" . $req->countryCode . "'";
        }



        $data = DB::SELECT($user);
        $total = count($data);


        $user .= " ORDER BY " . $columns[$req->order[0]['column']] . " " . $req->order[0]['dir'] . " LIMIT $req->length OFFSET $req->start ";


        $dataLimit = DB::SELECT($user);
        return response()->json([
            'draw'            => $req->draw,
            'recordsTotal'    => $total,
            "recordsFiltered" => $total,
            'data'            => $dataLimit,
        ]);
    }

    public function downloadCsv(Request $req)
    {

        $user = "SELECT user_id,username,real_name,last_active_at,status,country_code,created_at FROM users WHERE true";
        if ($req->username != null) {
            $user .= " AND username ILIKE '%$req->username%'";
        }
        if ($req->countryCode != null) {
            $user .= " AND country_code ILIKE '%$req->countryCode%'";
        }



        $data = DB::SELECT($user);

        $filename = "Data User List-" . md5(date("Y-m-d H:i:s")) . '.csv';
        $path = Storage::path($filename);
        $headers = array(
            "Content-type" => "text/csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, userPost-check=0, pre-check=0",
            "Expires" => "0"
        );
        $file = fopen($path, 'w');
        fputcsv(
            $file,
            [
                '', '', '', '', '',
                "Data User List"
            ],
            ";"
        );
        //EMTER
        fputcsv($file, [], ";");
        fputcsv($file, ["Download Time :", Carbon::now()->toDateTimeString()], ";");
        // fputcsv($file,[],"\t");
        // fputcsv($file,["\t","Download by :",SessionUtil::getUsername()],"\t");
        // fputcsv($file,["\t","Tanggal Download :",$this->formatDate(DateUtil::dateTimeNow(),'12')],"\t");
        fputcsv($file, [], ";");
        fputcsv($file, [
            "Username",
            "Real Name",
            "Country Code",
            "Registered At",
            "Last Active",
            "Status"
        ], ";");

        foreach ($data as $row => $value) {
            $body = [
                $value->username,
                $value->real_name,
                $value->country_code,
                Carbon::parse($value->created_at),
                Carbon::parse($value->last_active_at),
                $value->status,
            ];
            fputcsv($file, $body, ";");
        }
        fclose($file);

        return response()->download($path, $filename, $headers);
    }

    public function userDetailView(Request $req)
    {
        $user = UserApps::find($req->user_id);

        return view('pages.users.userDetail', [
            'category_name' => 'view_users',
            'page_name' => 'User Detail ',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',
            'data'   => $user,
        ]);
    }


    public function updateStatus(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'user_id' => 'required|string',
            ]);

            $userApp = UserApps::find($validatedData['user_id']);
            if (!$userApp) {
                return response()->json([
                    'success' => false,
                    'message' => "Data User Not Found"
                ], 404);
            }

            if ($userApp->status == 'Y') {
                $this->updateRemoteStatus('delete', $userApp);
                $userApp->status = 'N';
            } else {
                // $this->updateRemoteStatus('add', $userApp);
                $userApp->status = 'Y';
            }
            $userApp->save();
            return response()->json([
                'success' => true,
                'status' => $userApp->status,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    private function updateRemoteStatus($action, UserApps $userApp)
    {
        $client = new Client(env('GET_STREAM_KEY'), env('GET_STREAM_SECRET'));
        if ($action == 'add') {
            $status = $client->users()->add($userApp->user_id, [
                "created_at" => Carbon::now()->toISOString(),
                "human_id" => $userApp->human_id,
                "profile_pic_url" => $userApp->profile_pic_path,
                "username" => $userApp->username
            ]);
        } elseif ($action == 'delete') {
            $status = $client->users()->delete($userApp->user_id);
        }
    }

    public function bannedUser($id)
    {
        try {

            /**
             * TODO:
             * 1. update status is banned menjadi true
             * 2. hapus semua post berdasarkan user tersebut
             * 3. hapus semua atau keluarkan user tersebut dari chat
             */

            DB::beginTransaction();
            $userApp = UserApps::find($id);
            if ($userApp) {
                $userApp->status = "N";
                $userApp->is_banned = true;
                $userApp->save();
                $streamChat = new ChatGetStreamService();
                $streamChat->deActiveUser($id);
                DB::commit();
                return $this->successResponse('success banned user');
            }
            return $this->errorResponse('failed banned user', 400);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->errorResponse($th->getMessage());
        }
    }
}
