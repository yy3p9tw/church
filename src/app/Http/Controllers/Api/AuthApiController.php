<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthApiController extends Controller
{
    /**
     * 登入，回傳 JWT token
     */
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        if (!$token = auth('api')->attempt($credentials)) {
            return response()->json(['message' => '帳號或密碼錯誤'], 401);
        }
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60,
            'user' => auth('api')->user(),
        ]);
    }

    /**
     * 登出
     */
    public function logout()
    {
        auth('api')->logout();
        return response()->json(['message' => '已登出']);
    }

    /**
     * 取得目前登入者資訊
     */
    public function me()
    {
        return response()->json(auth('api')->user());
    }
}
