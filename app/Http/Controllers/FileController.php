<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\JsonResponse;

class FileController extends Controller
{

    /**
     * @param Image $file
     * @return JsonResponse
     */
    public function delete(Image $file): JsonResponse
    {
        return response()->json($file->delete());
    }
}
