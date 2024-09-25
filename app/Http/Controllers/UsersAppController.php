<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\UserApps;
use App\Models\UserScoreModel;
use App\Services\ChatGetStreamService;
use App\Services\FeedGetStreamService;
use App\Services\QueueService;
use App\Services\UserService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use GetStream\Stream\Client;
use Illuminate\Support\Facades\DB;

class UsersAppController extends Controller
{

    private QueueService $queueService;
    public function __construct(private UserService $userService)
    {
        $this->queueService = new QueueService();
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
        $query = UserApps::userQuery($req);
        $users = $query->get();

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
                '',
                '',
                '',
                '',
                '',
                "Data User List"
            ],
            ";"
        );
        fputcsv($file, [], ";");
        fputcsv($file, ["Download Time :", Carbon::now()->toDateTimeString()], ";");
        fputcsv($file, [], ";");
        fputcsv($file, [
            "User Id",
            "Username",
            "Country Code",
            "Registered At",
            "Last Active",
            "Topics",
            "Status"
        ], ";");
        foreach ($users as $user) {
            $topics = '';
            if (count($user->userTopics) >= 1) {
                foreach ($user->userTopics as $topic) {
                    $name = $topic->topic->name ?? '';
                    $topics = $topics . $name . ',';
                }
            }
            $body = [
                $user->user_id,
                $user->username,
                $user->country_code,
                Carbon::parse($user->created_at),
                Carbon::parse($user->last_active_at),
                $topics,
                $user->status,
            ];
            fputcsv($file, $body, ";");
        }
        fclose($file);

        return response()->download($path, $filename, $headers);
    }

    public function userDetailView(Request $req)
    {
        $userId = $req->user_id;
        $user = UserApps::getUserDetail($userId);
        return view('pages.users.userDetail', [
            'category_name' => 'view_users',
            'page_name' => 'User Detail',
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
            $client->users()->add($userApp->user_id, [
                "created_at" => Carbon::now()->toISOString(),
                "human_id" => $userApp->human_id,
                "profile_pic_url" => $userApp->profile_pic_path,
                "username" => $userApp->username
            ]);
        } elseif ($action == 'delete') {
            $client->users()->delete($userApp->user_id);
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

    public function blockUserByAdmin(Request $request)
    {
        try {
            $request->validate([
                'user_id' => 'required'
            ]);

            $res = $this->queueService->blockUser($request->input('user_id'));

            $code = $res['code'];
            if ($code != 200) {
                return $this->errorResponse($res['message'], 400);
            }
            return $this->successResponse($res['message']);
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage(), 400);
        }
    }

    public function unBlockUserByAdmin(Request $request)
    {
        try {
            $request->validate([
                'user_id' => 'required'
            ]);

            $res = $this->queueService->unBlockUser($request->input('user_id'));

            $code = $res['code'];
            if ($code != 200) {
                return $this->errorResponse($res['message'], 400);
            }
            return $this->successResponse($res['message'], $res);
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage(), 400);
        }
    }

    public function customeRank(Request $request)
    {
        try {
            $request->validate([
                'userId' => 'required|exists:users,user_id',
                'score' => 'required'
            ]);
            $res = $this->queueService->customeRank($request->input('userId'), $request->input('score'));

            $code = $res['code'];
            if ($code != 200) {
                return $this->errorResponseWithAlert('Failed to proses custome rank', 400);
            }
            return $this->successResponseWithAlert('being processed in queue');
        } catch (\Throwable $th) {
            return $this->errorResponseWithAlert($th->getMessage());
        }
    }
}
