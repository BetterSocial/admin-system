<?php

namespace App\Http\Controllers;


use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Domain;
use App\Models\LogModel;
use App\Repositories\DomainRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DomainController extends Controller
{

    public function __construct(private DomainRepository $domainRepository)
    {
    }
    public function index()
    {
        $data = [
            'category_name' => 'domain',
            'page_name' => 'domain list',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',

        ];
        return view('pages.domain.domain', $data);
    }
    public function getData(Request $req)
    {
        $draw = (int) $req->input('draw', 0);
        return response()->json($this->domainRepository->getData(
            $req->domainName,
            $req->order[0]['column'],
            $req->order[0]['dir'],
            $req->start,
            $req->length,
            $draw,
        ));
    }

    public function formEdit(Request $req)
    {
        $findDomain = Domain::find($req->domain_page_id);

        return view('pages.domain.add_logo_domain', [
            'category_name' => 'domain',
            'page_name' => 'add-logo-domain',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',
            'data' => $findDomain,

        ]);
    }

    public function saveLogo(Request $req)
    {

        try {
            $file = $req->file('file');

            $this->validate($req, [
                'file' => 'image|max:1024|dimensions:min_width=64,min_height=64',

            ]);
            $findDomain =  Domain::find($req->id);

            if ($findDomain->count() <= 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data topic not found'
                ]);
            }

            $response =  $req->file->storeOnCloudinary('domain-image')->getSecurePath();
            $findDomain->logo = $response;
            $findDomain->save();
            LogModel::insertLog('save-logo', 'success save logo');
            return response()->json([
                'success' => true,
            ]);
        } catch (\Exception $e) {
            LogModel::insertLog('save-logo', 'fail save logo ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function updateStatus(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required',
                'status' => 'required|boolean'
            ]);
            DB::beginTransaction();
            $domain = Domain::find($request->id);
            $domain->status = $request->status;
            $domain->save();
            DB::commit();
            return $this->successResponse('Success update status');
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->errorResponse($th->getMessage());
        }
    }
}
