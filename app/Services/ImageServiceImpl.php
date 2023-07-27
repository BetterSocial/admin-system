<?php

namespace App\Services;

use Illuminate\Http\Request;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class ImageServiceImpl implements ImageService
{

    public function __construct()
    {
    }

    public function uploadImage(Request $request): string
    {
        $imagePath = $request->file('image')->getRealPath();

        // Upload gambar ke Cloudinary
        $uploadResult = Cloudinary::upload($imagePath);

        // Ambil URL gambar yang diunggah dari respons Cloudinary
        $imageUrl = $uploadResult->getSecurePath();
        return $imageUrl;
    }
}
