<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function errorResponse($message = null, $data = [], $httpCode = 400)
    {
        $result = [
            'success' => false,
            'message' => $message,
            'data' => $data,
        ];

        return response()->json($result, $httpCode);
    }

    public function successResponse($data = [], $httpCode = 200)
    {
        $result = [
            'success' => true,
            'data' => $data,
        ];

        return response()->json($result, $httpCode);
    }
}
