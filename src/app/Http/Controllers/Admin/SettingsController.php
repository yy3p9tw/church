<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    // 系統設定首頁
    public function index()
    {
        // 可於此顯示與編輯系統設定
        return view('admin.settings.index');
    }
}
