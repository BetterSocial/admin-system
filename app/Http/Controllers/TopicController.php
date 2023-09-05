<?php

namespace App\Http\Controllers;

use App\Exports\TopicsExport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\LogErrorModel;
use App\Models\LogModel;
use App\Models\Topics;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Excel as ExcelExcel;
use Maatwebsite\Excel\Facades\Excel;

class TopicController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */


    public function index(Request $request)
    {
        $categories = Topics::category()->get();
        $data = [
            'category_name' => 'topics',
            'page_name' => 'topics',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',
            'category' => $categories,

        ];
        return view('pages.topic.topics')->with($data);
    }

    public function getData(Request $req)
    {
        try {
            return Topics::getData($req);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
            ], 500);
        }
    }



    public function addTopics(Request $req)
    {

        try {
            $this->validate($req, [
                'name' => [
                    'required',
                    'not_regex:/[&\s]/',
                ],
                'sort' => 'required|integer',
                'category' => '',
                'file' => 'nullable',

            ], [
                'name.not_regex' => 'Name field should not contain spaces or & characters.',
            ]);
            $name = strtolower($req->name);
            $category = $req->category;
            $check = DB::table('topics')->where([['name', '=', $name]])->count();

            if ($check > 0) {
                return $this->errorResponseWithAlert("A topic with the name '$name' already exists.");
            }
            if ($req->hasFile('file')) {
                $response =  $req->file->storeOnCloudinary('icons')->getSecurePath();
                $req->merge([
                    'icon_path' => $response
                ]);
            } else {
                $req->merge([
                    'icon_path' => 'https://res.cloudinary.com/hpjivutj2/image/upload/v1617245336/Frame_66_1_xgvszh.png'
                ]);
            }

            DB::beginTransaction();
            Topics::create($req->merge([
                'name' => $name,
                'categories' => $category ?? '',
                'created_at' => Carbon::now()
            ])->all());
            LogModel::insertLog('add-topic', 'success add new topic');
            DB::commit();
            return $this->successResponseWithAlert('Successfully added the topic.', 'topic');
        } catch (Exception $e) {
            DB::rollBack();
            LogModel::insertLog('add-topics', 'error add topic with error' . $e->getMessage());
            LogErrorModel::create([
                'message' => $e->getMessage(),
            ]);
            return $this->errorResponseWithAlert($e->getMessage());
        }
    }

    public function showTopics(Request $req)
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
                $data = Topics::find($req->topic_id);
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
                        'message' => "Data Topic Not Found"
                    ]);
                }
            }
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function category(Request $request)
    {
        try {
            $categories = Topics::category()->get();
            return $this->successResponse('success get category topic', $categories);
        } catch (\Throwable $th) {
            //throw $th;
            return $this->errorResponse($th->getMessage());
        }
    }

    public function update(Request $request)
    {
        try {
            $request->validate(
                [
                    'topic_id' => 'required',
                    'name' => [
                        'nullable',
                        'not_regex:/[&\s]/',
                    ],
                ],
                [
                    'topic_id' => 'Topic Id is Required'
                ]
            );
            $topic = Topics::find($request->topic_id);
            Topics::updateTopic($topic, $request);
            LogModel::insertLog('update-topic', 'success update topic');
            return $this->successResponse('success update topic');
        } catch (\Throwable $th) {
            LogModel::insertLog('update-topic', 'error update topic with error ' . $th->getMessage());
            return $this->errorResponse($th->getMessage(), 400);
        }
    }

    public function delete($id)
    {
        try {
            DB::beginTransaction();
            $data = Topics::find($id);
            $data->delete();
            LogModel::insertLog('delete-topic', 'success delete topic');
            DB::commit();
            return $this->successResponse('success delete topic');
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            LogModel::insertLog('delete-topic', 'error delete topic with error ' . $th->getMessage());
            return $this->errorResponse($th->getMessage());
        }
    }

    public function export()
    {
        LogModel::insertLog('export-topic', 'success export topic');
        return Excel::download(new TopicsExport, 'topics.csv', ExcelExcel::CSV);
    }

    public function unSignCategory(Request $request)
    {
        try {

            $request->validate([
                'topic_id' => 'required|exists:topics,topic_id',
            ], [
                'topic_id.required' => 'Topic ID is required',
                'topic_id.exists' => 'Topic ID not found',
            ]);
            DB::beginTransaction();
            $data = Topics::find($request->topic_id);
            $data->update([
                'sign' => false
            ]);
            LogModel::insertLog('un-sign-category-topic', 'success update unSign Category topic');
            DB::commit();
            return $this->successResponseWithAlert('Success Remove Topic from OB');
        } catch (\Throwable $th) {
            DB::rollBack();
            LogModel::insertLog('un-sign-category-topic', 'fail update unSign Category topic');
            return $this->errorResponseWithAlert('Fail Remove Topic from OB');
        }
    }

    public function signCategory(Request $request)
    {
        try {
            $request->validate([
                'topic_id' => 'required|exists:topics,topic_id',
            ], [
                'topic_id.required' => 'Topic ID is required',
                'topic_id.exists' => 'Topic ID not found',
            ]);

            $id = $request->topic_id;
            DB::beginTransaction();
            $data = Topics::find($id);
            $data->update([
                'sign' => true
            ]);
            LogModel::insertLog('sign-category-topic', 'success update Sign Category topic');
            DB::commit();
            return $this->successResponseWithAlert('Success Add Topic to OB');
        } catch (\Throwable $th) {
            DB::rollBack();
            LogModel::insertLog('sign-category-topic', 'fail with error ' . $th->getMessage());
            return $this->errorResponseWithAlert('Fail Add Topic to OB');
        }
    }

    public function removeDuplicate(Request $request)
    {
        try {
            $request->validate([
                'option' => 'required'
            ]);
            Topics::removeDuplicateTopicName($request->input('option'));
            return $this->successResponseWithAlert('Successfully deleted the same topic');
        } catch (\Throwable $th) {
            if ($th instanceof ValidationException) {
                return $this->errorResponseWithAlert('Option is required');
            }
            return $this->errorResponseWithAlert('Failed to delete the same topic.');
        }
    }
}
