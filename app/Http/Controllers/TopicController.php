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
        // $request->merge([
        //     'search_name' => null,
        //     'search_category' => null,
        //     'order_column_index' => 1,
        //     'order_direction' => 'asc',
        //     'start' => 0,
        //     'length' => 50
        // ]);
        // return $this->getData($request);
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
            $columns = array(
                0 => 'topic_id',
                1 => 'name',
                2 => 'icon_path',
                3 => 'categories',
                4 => 'created_at',
                5 => 'sort',
                6 => 'followers',
                7 => 'total_user_topics',
                7 => 'flg_show',
            );
            $searchName = $req->input('name');
            $searchCategory = $req->input('category');
            $orderColumnIndex = (int) $req->input('order.0.column');
            $orderDirection = $req->input('order.0.dir', 'asc');
            $start = (int) $req->input('start', 0);
            $length = (int) $req->input('length', 10);

            $testData = [
                'search_name' => $searchName,
                'search_category' => $searchCategory,
                'order_column_index' => $orderColumnIndex,
                'order_direction' => $orderDirection,
                'start' => $start,
                'length' => $length,
            ];

            file_put_contents(time() . '.json', json_encode($testData));


            $query = Topics::select('topics.topic_id', 'topics.name', 'topics.icon_path', 'topics.categories', 'topics.created_at', 'topics.sort', 'topics.flg_show', 'topics.sign')
                ->whereNull('topics.deleted_at');

            $query->withCount('topicUsers AS total_user_topics');

            if ($searchName !== null) {
                $query->where('topics.name', 'ILIKE', '%' . $searchName . '%');
            }

            if ($searchCategory !== null) {
                $query->where('topics.categories', 'ILIKE', '%' . $searchCategory . '%');
            }

            $total = $query->count();

            $query->orderBy($columns[$orderColumnIndex], $orderDirection)
                ->offset($start)
                ->limit($length);

            $data = $query->get();

            return response()->json([
                'draw' => (int) $req->input('draw', 1),
                'recordsTotal' => $total,
                'recordsFiltered' => $total,
                'data' => $data,
            ]);
        } catch (\Throwable $th) {
            file_put_contents('test.txt', $th->getMessage());
            return response()->json([
                'error' => 'An error occurred while retrieving the data.',
            ], 500);
        }
    }


    public function addTopics(Request $req)
    {

        try {
            $this->validate($req, [
                'name' => 'required',
                'sort' => 'required|integer',
                'category' => 'required',

            ]);
            $name = strtolower($req->name);
            $category = $req->category;
            $check = DB::table('topics')->where([['name', '=', $name], ['categories', '=', $category]])->count();

            if ($check > 0) {
                return $this->errorResponse('Data topic with name ' . $name . ' and category ' . $category . ' already exists', 400);
            }
            $req->merge([
                'icon_path' => 'https://res.cloudinary.com/hpjivutj2/image/upload/v1617245336/Frame_66_1_xgvszh.png'
            ]);

            DB::beginTransaction();
            Topics::create($req->merge([
                'name' => $name,
                'categories' => $category,
                'created_at' => Carbon::now()
            ])->all());
            LogModel::insertLog('add-topic', 'success add new topic');
            DB::commit();
            return $this->successResponse('success create new topic');
        } catch (Exception $e) {
            DB::rollBack();
            LogModel::insertLog('add-topics', 'error add topic with error' . $e->getMessage());
            LogErrorModel::create([
                'message' => $e->getMessage(),
            ]);
            return $this->errorResponse($e->getMessage());
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
            $request->validate([
                'topic_id' => 'required',
            ]);
            $topic = Topics::find($request->topic_id);
            Topics::updateTopic($topic, $request->all());
            LogModel::insertLog('update-topic', 'success update topic');
            return $this->successResponse('success update topic');
        } catch (\Throwable $th) {
            LogModel::insertLog('update-topic', 'error update topic with error ' . $th->getMessage());
            return $this->errorResponse('failed update topic', 400);
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
            return $this->successResponseWithAlert('success UnSign Category');
        } catch (\Throwable $th) {
            DB::rollBack();
            LogModel::insertLog('un-sign-category-topic', 'fail update unSign Category topic');
            return $this->errorResponseWithAlert($th->getMessage());
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
            return $this->successResponseWithAlert('Success Sign Category');
        } catch (\Throwable $th) {
            DB::rollBack();
            LogModel::insertLog('sign-category-topic', 'fail with error ' . $th->getMessage());
            return $this->errorResponseWithAlert($th->getMessage());
        }
    }
}
