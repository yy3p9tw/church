@extends('layouts.admin')
@section('content')
<div class="container py-4">
    <h2>新增消息</h2>
    <form method="POST" action="{{ route('admin.news.store') }}">
        @csrf
        <div class="mb-3">
            <label>標題</label>
            <input type="text" name="title" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>日期</label>
            <input type="date" name="news_date" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>內容</label>
            <textarea name="content" class="form-control"></textarea>
        </div>
        <button class="btn btn-primary">儲存</button>
        <a href="{{ route('admin.news.index') }}" class="btn btn-secondary">返回</a>
    </form>
</div>
@endsection
