<?php

namespace App\Http\Controllers;

use App\Models\RssLinkModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RssLinkController extends Controller
{
    public function data(Request $request)
    {
        $rss = RssLinkModel::all();
        $data = [
            'category_name' => 'rss',
            'page_name' => 'rss',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',
            'rss' => $rss,

        ];
        return view('pages.rss', $data);
    }

    public function add(Request $request)
    {
        try {
            $request->validate([
                'domain_name' => 'required',
                'link' => 'required'
            ]);
            DB::beginTransaction();
            RssLinkModel::create($request->all());
            DB::commit();
            return $this->successResponseWithAlert('Success create Rss');
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return $this->errorResponseWithAlert($th->getMessage());
        }
    }

    public function edit(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required',
                'domain_name' => 'required',
                'link' => 'required'
            ]);
            DB::beginTransaction();
            $rss = RssLinkModel::find($request->id);
            $rss->update($request->all());
            DB::commit();
            return $this->successResponseWithAlert('Success updated Rss',);
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return $this->errorResponseWithAlert($th->getMessage());
        }
    }

    public function remove($id)
    {
        try {
            DB::beginTransaction();
            $rss = RssLinkModel::find($id);
            $rss->delete();
            DB::commit();
            return $this->successResponseWithAlert('success delete link');
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return $this->errorResponseWithAlert($th->getMessage());
        }
    }
}
