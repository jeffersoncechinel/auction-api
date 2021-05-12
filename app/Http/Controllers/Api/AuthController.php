<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        $credentials = $request->only('username', 'password');

        if (Auth::validate($credentials)) {
            return $this->successResponse(Auth::user()->safeData());
        }

        return $this->errorResponse('Invalid password');
    }
}
