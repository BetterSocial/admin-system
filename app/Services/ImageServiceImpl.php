<?php

namespace App\Services;

use Illuminate\Http\Request;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class ImageServiceImpl implements ImageService
{

    public function __construct()
    {
    }

    public function uploadImage($realPath): string
    {
        try {
            // Upload gambar ke Cloudinary
            $uploadResult = Cloudinary::upload($realPath);

            // Ambil URL gambar yang diunggah dari respons Cloudinary
            $imageUrl = $uploadResult->getSecurePath();
            return $imageUrl;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
