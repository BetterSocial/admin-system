<?php

namespace App\Services;

use Illuminate\Http\Request;

interface ImageService
{

    public function uploadImage($realPath);
}
