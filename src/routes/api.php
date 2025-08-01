<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\SermonApiController;
use App\Http\Controllers\Api\NewsApiController;
use App\Http\Controllers\Api\EventApiController;
use App\Http\Controllers\Api\GroupApiController;

// 講道 API
Route::get('/sermons', [SermonApiController::class, 'index']);
Route::get('/sermons/{id}', [SermonApiController::class, 'show']);

// 消息 API
Route::get('/news', [NewsApiController::class, 'index']);
Route::get('/news/{id}', [NewsApiController::class, 'show']);

// 活動 API
Route::get('/events', [EventApiController::class, 'index']);
Route::get('/events/{id}', [EventApiController::class, 'show']);

// 小組 API
Route::get('/groups', [GroupApiController::class, 'index']);
Route::get('/groups/{id}', [GroupApiController::class, 'show']);
