@extends('layouts.admin')
@section('content')
<div class="container py-4">
    <h2>編輯小組</h2>
    <form method="POST" action="{{ route('admin.groups.update', $group) }}">
        @csrf @method('PUT')
        <div class="mb-3">
            <label>名稱</label>
            <input type="text" name="name" class="form-control" value="{{ $group->name }}" required>
        </div>
        <div class="mb-3">
            <label>類型</label>
            <input type="text" name="type" class="form-control" value="{{ $group->type }}">
        </div>
        <div class="mb-3">
            <label>聯絡人</label>
            <input type="text" name="contact_person" class="form-control" value="{{ $group->contact_person }}">
        </div>
        <div class="mb-3">
            <label>描述</label>
            <textarea name="description" class="form-control">{{ $group->description }}</textarea>
        </div>
        <button class="btn btn-primary">更新</button>
        <a href="{{ route('admin.groups.index') }}" class="btn btn-secondary">返回</a>
    </form>
</div>
@endsection
