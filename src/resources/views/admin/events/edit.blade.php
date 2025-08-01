@extends('layouts.admin')
@section('content')
<div class="container py-4">
    <h2>編輯活動</h2>
    <form method="POST" action="{{ route('admin.events.update', $event) }}">
        @csrf @method('PUT')
        <div class="mb-3">
            <label>標題</label>
            <input type="text" name="title" class="form-control" value="{{ $event->title }}" required>
        </div>
        <div class="mb-3">
            <label>開始日期時間</label>
            <input type="datetime-local" name="start_time" class="form-control" value="{{ $event->start_time ? date('Y-m-d\TH:i', strtotime($event->start_time)) : '' }}" required>
        </div>
        <div class="mb-3">
            <label>結束日期時間</label>
            <input type="datetime-local" name="end_time" class="form-control" value="{{ $event->end_time ? date('Y-m-d\TH:i', strtotime($event->end_time)) : '' }}">
        </div>
        <div class="mb-3">
            <label>地點</label>
            <input type="text" name="location" class="form-control" value="{{ $event->location }}">
        </div>
        <div class="mb-3">
            <label>內容</label>
            <textarea name="content" class="form-control">{{ $event->content }}</textarea>
        </div>
        <button class="btn btn-primary">更新</button>
        <a href="{{ route('admin.events.index') }}" class="btn btn-secondary">返回</a>
    </form>
</div>
@endsection
