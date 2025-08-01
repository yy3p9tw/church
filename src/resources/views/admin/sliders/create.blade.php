@extends('layouts.admin')
@section('content')
<div class="container py-4">
    <h2>新增輪播</h2>
    <form method="POST" action="{{ route('admin.sliders.store') }}">
        @csrf
        <div class="mb-3">
            <label>標題</label>
            <input type="text" name="title" class="form-control">
        </div>
        <div class="mb-3">
            <label>圖片網址</label>
            <input type="text" name="image_url" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>連結網址</label>
            <input type="text" name="link_url" class="form-control">
        </div>
        <div class="mb-3">
            <label>排序</label>
            <input type="number" name="sort_order" class="form-control" value="0">
        </div>
        <button class="btn btn-primary">儲存</button>
        <a href="{{ route('admin.sliders.index') }}" class="btn btn-secondary">返回</a>
    </form>
</div>
@endsection
