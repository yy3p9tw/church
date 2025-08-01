@extends('layouts.admin')
@section('content')
<div class="container py-4">
    <h2>編輯週報</h2>
    <form method="POST" action="{{ route('admin.bulletins.update', $bulletin) }}" enctype="multipart/form-data">
        @csrf @method('PUT')
        <div class="mb-3">
            <label>標題</label>
            <input type="text" name="title" class="form-control" value="{{ old('title', $bulletin->title) }}" required>
        </div>
        <div class="mb-3">
            <label>日期</label>
            <input type="date" name="publish_date" class="form-control" value="{{ old('publish_date', $bulletin->publish_date) }}">
        </div>
        <div class="mb-3">
            <label>週報圖片</label>
            <input type="text" name="image_url" class="form-control" value="{{ old('image_url', $bulletin->image_url) }}" placeholder="請填入圖片網址">
        </div>
        <button class="btn btn-primary">更新</button>
        <a href="{{ route('admin.bulletins.index') }}" class="btn btn-secondary">返回</a>
    </form>
</div>
@endsection
