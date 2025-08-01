@extends('layouts.front')
@section('content')
<div class="container py-4">
    <h2>系統設定</h2>
    <div class="alert alert-info">此區可擴充為各項全域設定、站台參數、聯絡資訊等管理介面。</div>
    <form method="POST" action="#">
        @csrf
        <div class="mb-3">
            <label>網站名稱</label>
            <input type="text" name="site_name" class="form-control" value="{{ config('app.name') }}">
        </div>
        <button class="btn btn-primary" disabled>儲存（範例，尚未實作）</button>
    </form>
</div>
@endsection
