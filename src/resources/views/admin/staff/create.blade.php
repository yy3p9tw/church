@extends('layouts.admin')
@section('content')
<div class="container py-4">
    <h2>新增同工</h2>
    <form action="{{ route('admin.staff.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label class="form-label">姓名</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">職稱</label>
            <input type="text" name="title" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">照片</label>
            <input type="file" name="photo" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">簡介</label>
            <textarea name="bio" class="form-control"></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">排序</label>
            <input type="number" name="sort_order" class="form-control" value="0">
        </div>
        <div class="mb-3">
            <label class="form-label">狀態</label>
            <select name="status" class="form-select">
                <option value="1">啟用</option>
                <option value="0">停用</option>
            </select>
        </div>
        <button class="btn btn-primary">儲存</button>
        <a href="{{ route('admin.staff.index') }}" class="btn btn-secondary">返回</a>
    </form>
</div>
@endsection
