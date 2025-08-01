@extends('layouts.admin')
@section('content')
<div class="container py-4">
    <h2>編輯輪播</h2>
    <form method="POST" action="{{ route('admin.sliders.update', $slider) }}">
        @csrf @method('PUT')
        <div class="mb-3">
            <label>標題</label>
            <input type="text" name="title" class="form-control" value="{{ $slider->title }}">
        </div>
        <div class="mb-3">
            <label>圖片網址</label>
            <input type="text" name="image_url" class="form-control" value="{{ $slider->image_url }}" required>
        </div>
        <div class="mb-3">
            <label>連結網址</label>
            <input type="text" name="link_url" class="form-control" value="{{ $slider->link_url }}">
        </div>
        <div class="mb-3">
            <label>排序</label>
            <input type="number" name="sort_order" class="form-control" value="{{ $slider->sort_order }}">
        </div>
        <button class="btn btn-primary">更新</button>
        <a href="{{ route('admin.sliders.index') }}" class="btn btn-secondary">返回</a>
    </form>
</div>
@endsection
