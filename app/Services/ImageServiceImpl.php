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
        $uploadResult = Cloudinary::upload($realPath);
        $imageUrl = $uploadResult->getSecurePath();
        return $imageUrl;
    }
}
