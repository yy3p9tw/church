@extends('layouts.front')
@section('content')
<div class="container py-4">
    <h2>系統監控</h2>
    <div class="alert alert-info">此區可擴充為系統健檢、備份、錯誤日誌等管理介面。</div>
    <ul>
        <li>PHP 版本：{{ phpversion() }}</li>
        <li>Laravel 版本：{{ app()->version() }}</li>
        <li>伺服器時間：{{ now() }}</li>
        <li>資料庫連線：@php try { DB::connection()->getPdo(); echo '正常'; } catch (Exception $e) { echo '異常'; } @endphp</li>
    </ul>
</div>
@endsection
