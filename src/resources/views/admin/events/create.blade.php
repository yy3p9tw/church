@extends('layouts.admin')
@section('content')
<div class="container py-4">
    <h2>新增活動</h2>
    <form method="POST" action="{{ route('admin.events.store') }}">
        @csrf
        <div class="mb-3">
            <label>標題</label>
            <input type="text" name="title" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>開始日期時間</label>
            <input type="datetime-local" name="start_time" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>結束日期時間</label>
            <input type="datetime-local" name="end_time" class="form-control">
        </div>
        <div class="mb-3">
            <label>地點</label>
            <input type="text" name="location" class="form-control">
        </div>
        <div class="mb-3">
            <label>內容</label>
            <textarea name="content" class="form-control"></textarea>
        </div>
        <button class="btn btn-primary">儲存</button>
        <a href="{{ route('admin.events.index') }}" class="btn btn-secondary">返回</a>
    </form>
</div>
@endsection
