@extends('layouts.admin')
@section('content')
<div class="container py-4">
    <h2>同工管理</h2>
    <a href="{{ route('admin.staff.create') }}" class="btn btn-primary mb-3">新增同工</a>
    <table class="table table-bordered">
        <thead><tr><th>姓名</th><th>職稱</th><th>照片</th><th>狀態</th><th>排序</th><th>操作</th></tr></thead>
        <tbody>
        @foreach($staff as $item)
            <tr>
                <td>{{ $item->name }}</td>
                <td>{{ $item->title }}</td>
                <td>@if($item->photo)<img src="{{ asset('storage/'.$item->photo) }}" width="60">@endif</td>
                <td>{{ $item->status ? '啟用' : '停用' }}</td>
                <td>{{ $item->sort_order }}</td>
                <td>
                    <a href="{{ route('admin.staff.edit', $item) }}" class="btn btn-sm btn-warning">編輯</a>
                    <form action="{{ route('admin.staff.destroy', $item) }}" method="POST" style="display:inline;">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger" onclick="return confirm('確定刪除？')">刪除</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {{ $staff->links() }}
</div>
@endsection
