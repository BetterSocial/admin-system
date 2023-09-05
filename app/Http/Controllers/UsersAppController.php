<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\UserApps;
use App\Services\ChatGetStreamService;
use App\Services\FeedGetStreamService;
use App\Services\UserService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use GetStream\Stream\Client;
use Illuminate\Support\Facades\DB;

class UsersAppController extends Controller
{

    public function __construct(private UserService $userService)
    {
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function getData(Request $req)
    {
        try {
            return UserApps::getData($req);
        } catch (\Throwable $th) {
            return response()->json([
                'draw'            => 0,
                'recordsTotal'    => 0,
                "recordsFiltered" => 0,
                'data'            => [],
            ]);
        }
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
        fputcsv($file, [], ";");
        fputcsv($file, [
            "User Id",
            "Username",
            "Real Name",
            "Country Code",
            "Registered At",
            "Last Active",
            "Status"
        ], ";");

        foreach ($data as $row => $value) {
            $body = [
                $value->user_id,
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
            DB::beginTransaction();
            $userApp = UserApps::find($id);
            if ($userApp) {
                $userApp->status = "N";
                $userApp->is_banned = true;
                $userApp->save();
                $streamChat = new ChatGetStreamService();
                $streamChat->deActiveUser($id);
                $feed = new FeedGetStreamService();
                $feed->updateExpireFeed($id);
                DB::commit();
                return $this->successResponse('success banned user');
            }
            return $this->errorResponse('failed banned user', 400);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->errorResponse($th->getMessage());
        }
    }

    public function getNameByAnonymousId(Request $request)
    {
        try {
            $request->validate([
                'user_id' => 'required'
            ]);
            $user = $this->userService->getUserByAnonymousId($request->input('user_id'));
            return $this->successResponse('success get data', [
                'username' => $user->username
            ]);
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage(), 400);
        }
    }
}
