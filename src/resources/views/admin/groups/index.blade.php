@extends('layouts.admin')
@section('content')
<div class="container py-4">
    <h2>小組管理</h2>
    <a href="{{ route('admin.groups.create') }}" class="btn btn-primary mb-3">新增小組</a>
    <table class="table table-bordered">
        <thead><tr><th>名稱</th><th>類型</th><th>聯絡人</th><th>操作</th></tr></thead>
        <tbody>
        @foreach($groups as $group)
            <tr>
                <td>{{ $group->name }}</td>
                <td>{{ $group->type }}</td>
                <td>{{ $group->contact_person }}</td>
                <td>
                    <a href="{{ route('admin.groups.edit', $group) }}" class="btn btn-sm btn-warning">編輯</a>
                    <form action="{{ route('admin.groups.destroy', $group) }}" method="POST" style="display:inline;">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger" onclick="return confirm('確定刪除？')">刪除</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {{ $groups->links() }}
</div>
@endsection
