<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthApiController;

Route::prefix('auth')->group(function () {
    Route::post('login', [AuthApiController::class, 'login']);
    Route::post('logout', [AuthApiController::class, 'logout'])->middleware('auth:api');
    Route::get('me', [AuthApiController::class, 'me'])->middleware('auth:api');

    // 範例：僅 admin 可存取
    Route::get('admin-test', function() {
        return response()->json(['message' => '只有 admin 可以看到這個訊息']);
    })->middleware(['auth:api', 'role:admin']);
});
