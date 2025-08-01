@extends('layouts.admin')
@section('content')
<div class="container py-4">
    <h2>編輯消息</h2>
    <form method="POST" action="{{ route('admin.news.update', $news) }}">
        @csrf @method('PUT')
        <div class="mb-3">
            <label>標題</label>
            <input type="text" name="title" class="form-control" value="{{ $news->title }}" required>
        </div>
        <div class="mb-3">
            <label>日期</label>
            <input type="date" name="news_date" class="form-control" value="{{ $news->news_date }}" required>
        </div>
        <div class="mb-3">
            <label>內容</label>
            <textarea name="content" class="form-control">{{ $news->content }}</textarea>
        </div>
        <button class="btn btn-primary">更新</button>
        <a href="{{ route('admin.news.index') }}" class="btn btn-secondary">返回</a>
    </form>
</div>
@endsection
