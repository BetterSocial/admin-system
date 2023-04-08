<?php

namespace App\Http\Controllers;

use App\Exports\TopicsExport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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
            //code...
            $columns = array(
                // datatable column index  => database column name
                0 => 'topic_id',
                1 => 'name',
                2 => 'icon_path',
                3 => 'categories',
                4 => 'created_at',
                5 => 'sort',
                6 => 'followers',
                7 => 'flg_show'
            );
            $topic = "SELECT topic_id,name,icon_path,categories,created_at,sort,'location',flg_show,sign FROM topics WHERE deleted_at IS NULL";

            // $topic .= " ";
            if ($req->name != null) {
                $topic .= " AND name ILIKE '%$req->name%'";
            }
            if ($req->category != null) {
                $topic .= " AND categories ILIKE '%$req->category%'";
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
        } catch (\Throwable $th) {
            //throw $th;
            file_put_contents('test.txt', $th->getMessage());
        }
    }

    public function addTopics(Request $req)
    {

        try {
            // $file = $req->file('file');

            $this->validate($req, [
                // 'file' => 'image|max:1024|dimensions:min_width=64,min_height=64',
                'sort' => 'required|integer'

            ]);
            // $name = ucfirst($req->name);
            // $category = ucfirst($req->category);
            $name = $req->name;
            $category = $req->category;
            $check = DB::table('topics')->where([['name', '=', $name], ['categories', '=', $category]])->count();

            if ($check > 0) {
                return $this->errorResponse('Data topic with name ' . $name . ' and category ' . $category . ' already exists');
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
                'categories' => $category,
                'created_at' => Carbon::now()
            ])->all());
            DB::commit();
            return $this->successResponse('success create new topic');
        } catch (Exception $e) {
            DB::rollBack();
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
            return $this->successResponse('success update topic');
        } catch (\Throwable $th) {
            return $this->errorResponse('failed update topic', 400);
        }
    }

    public function delete($id)
    {
        try {
            DB::beginTransaction();
            $data = Topics::find($id);
            $data->delete();
            DB::commit();
            return $this->successResponse('success delete topic');
        } catch (\Throwable $th) {
            //throw $th;
            return $this->errorResponse($th->getMessage());
        }
    }

    public function export()
    {
        return Excel::download(new TopicsExport, 'topics.csv', ExcelExcel::CSV);
    }

    public function unSignCategory($id)
    {
        try {

            DB::beginTransaction();
            $data = Topics::find($id);
            $data->update([
                'sign' => false
            ]);
            DB::commit();
            return $this->successResponse('success unSign Category');
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return $this->errorResponse($th->getMessage());
        }
    }

    public function signCategory($id)
    {
        try {

            DB::beginTransaction();
            $data = Topics::find($id);
            $data->update([
                'sign' => true
            ]);
            DB::commit();
            return $this->successResponse('success sign Category');
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return $this->errorResponse($th->getMessage());
        }
    }
}
