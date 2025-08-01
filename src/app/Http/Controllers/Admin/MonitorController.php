<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MonitorController extends Controller
{
    // 監控首頁
    public function index()
    {
        // 可於此顯示系統健檢、備份、錯誤日誌等
        return view('admin.monitor.index');
    }
}
