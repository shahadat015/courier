<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function successResponse($message, $data = '')
    {
        return response()->json(['success' => true, 'message' => __($message), 'data' => $data]);
    }

    public function errorResponse($message)
    {
        return response()->json(['error' => true, 'message' => __($message)]);
    }

    public function removeImage($image)
    {
        Storage::delete($image);
    }
}
