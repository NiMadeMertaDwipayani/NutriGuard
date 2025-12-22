<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (!$token = Auth::guard('api')->attempt($credentials)) {
            return response()->json([
                'status' => false,
                'message' => 'Login Gagal',
            ], 401);
        }

        return response()->json([
            'status' => true,
            'message' => 'Login Berhasil',
            'data' => [
                'user' => Auth::guard('api')->user(),
                'token' => $token
            ]
        ], 200);
    }

    // Logout API
    public function logout()
    {
        Auth::guard('api')->logout();
        return response()->json(['status' => true, 'message' => 'Logout Berhasil']);
    }
}
