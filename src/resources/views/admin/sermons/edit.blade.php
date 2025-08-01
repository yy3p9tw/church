@extends('layouts.admin')
@section('content')
<div class="container py-4">
    <h2>編輯講道</h2>
    <form method="POST" action="{{ route('admin.sermons.update', $sermon) }}">
        @csrf @method('PUT')
        <div class="mb-3">
            <label>標題</label>
            <input type="text" name="title" class="form-control" value="{{ $sermon->title }}" required>
        </div>
        <div class="mb-3">
            <label>講員</label>
            <input type="text" name="speaker" class="form-control" value="{{ $sermon->speaker }}" required>
        </div>
        <div class="mb-3">
            <label>日期</label>
            <input type="date" name="sermon_date" class="form-control" value="{{ $sermon->sermon_date ? (is_object($sermon->sermon_date) ? $sermon->sermon_date->format('Y-m-d') : $sermon->sermon_date) : '' }}" required>
        </div>
        <div class="mb-3">
            <label>YouTube 影片網址</label>
            <input type="text" name="video_url" class="form-control" value="{{ $sermon->video_url }}" placeholder="https://www.youtube.com/watch?v=...">
        </div>
        <div class="mb-3">
            <label>內容</label>
            <textarea name="content" class="form-control">{{ $sermon->content }}</textarea>
        </div>
        <button class="btn btn-primary">更新</button>
        <a href="{{ route('admin.sermons.index') }}" class="btn btn-secondary">返回</a>
    </form>
</div>
@endsection
