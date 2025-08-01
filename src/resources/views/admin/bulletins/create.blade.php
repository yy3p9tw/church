@extends('layouts.admin')
@section('content')
<div class="container py-4">
    <h2>新增週報</h2>
    <form method="POST" action="{{ route('admin.bulletins.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label>標題</label>
            <input type="text" name="title" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>日期</label>
            <input type="date" name="publish_date" class="form-control">
        </div>
        <div class="mb-3">
            <label>週報圖片</label>
            <input type="text" name="image_url" class="form-control" placeholder="請填入圖片網址">
        </div>
        <button class="btn btn-primary">儲存</button>
        <a href="{{ route('admin.bulletins.index') }}" class="btn btn-secondary">返回</a>
    </form>
</div>
@endsection
