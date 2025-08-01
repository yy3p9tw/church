@extends('layouts.admin')
@section('content')
<div class="container py-4">
    <h2>編輯同工</h2>
    <form action="{{ route('admin.staff.update', $staff) }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')
        <div class="mb-3">
            <label class="form-label">姓名</label>
            <input type="text" name="name" class="form-control" value="{{ $staff->name }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">職稱</label>
            <input type="text" name="title" class="form-control" value="{{ $staff->title }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">照片</label>
            @if($staff->photo)
                <img src="{{ asset('storage/'.$staff->photo) }}" width="80" class="mb-2"><br>
            @endif
            <input type="file" name="photo" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">簡介</label>
            <textarea name="bio" class="form-control">{{ $staff->bio }}</textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">排序</label>
            <input type="number" name="sort_order" class="form-control" value="{{ $staff->sort_order }}">
        </div>
        <div class="mb-3">
            <label class="form-label">狀態</label>
            <select name="status" class="form-select">
                <option value="1" @if($staff->status) selected @endif>啟用</option>
                <option value="0" @if(!$staff->status) selected @endif>停用</option>
            </select>
        </div>
        <button class="btn btn-primary">儲存</button>
        <a href="{{ route('admin.staff.index') }}" class="btn btn-secondary">返回</a>
    </form>
</div>
@endsection
