@extends('layouts.admin')
@section('content')
<div class="container py-4">
    <h2>新增小組</h2>
    <form method="POST" action="{{ route('admin.groups.store') }}">
        @csrf
        <div class="mb-3">
            <label>名稱</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>類型</label>
            <input type="text" name="type" class="form-control">
        </div>
        <div class="mb-3">
            <label>聯絡人</label>
            <input type="text" name="contact_person" class="form-control">
        </div>
        <div class="mb-3">
            <label>描述</label>
            <textarea name="description" class="form-control"></textarea>
        </div>
        <button class="btn btn-primary">儲存</button>
        <a href="{{ route('admin.groups.index') }}" class="btn btn-secondary">返回</a>
    </form>
</div>
@endsection
