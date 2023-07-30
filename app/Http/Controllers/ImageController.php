<?php

namespace App\Http\Controllers;

use App\Models\ImageModel;
use App\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ImageController extends Controller
{

    public function index(Request $request)
    {
        $data = [
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',
            'category_name' => 'images',
            'page_name' => 'Images',
        ];
        return view('pages.images.image', $data);
    }

    public function data(Request $request)
    {
        try {
            return ImageModel::getData($request);
        } catch (\Throwable $th) {
            file_put_contents('tes.txt', $th->getMessage());
            return response()->json([
                'error' => $th->getMessage(),
            ], 500);
        }
    }

    public function uploadImage(Request $request, ImageService $imageService)
    {
        try {

            $request->validate([
                'images.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:2000',
            ]);
            if (!$request->hasFile('images')) return $this->errorResponseWithAlert('File Not found');
            // Dapatkan objek UploadedFile dari request

            DB::beginTransaction();
            foreach ($request->file('images') as $uploadedFile) {

                // Dapatkan nama file asli
                $originalName = $uploadedFile->getClientOriginalName();


                //code...
                $realPath = $uploadedFile->getRealPath();

                $url =  $imageService->uploadImage($realPath);

                // Dapatkan nama file asli
                $originalName = $uploadedFile->getClientOriginalName();

                // Dapatkan ekstensi filed
                ImageModel::create([
                    'name' => $originalName,
                    'url' => $url,
                ]);
            }
            DB::commit();
            return $this->successResponseWithAlert('Success upload image');
        } catch (\Throwable $th) {
            dd($th->getMessage());
            DB::rollBack();
            return $this->errorResponseWithAlert($th->getMessage());
        }
    }
}
