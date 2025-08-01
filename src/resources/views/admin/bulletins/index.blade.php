@extends('layouts.admin')
@section('content')
<div class="container py-4">
    <h2>週報管理</h2>
    <a href="{{ route('admin.bulletins.create') }}" class="btn btn-primary mb-3">新增週報</a>
    <table class="table table-bordered">
        <thead><tr><th>標題</th><th>日期</th><th>圖片</th><th>操作</th></tr></thead>
        <tbody>
        @foreach($bulletins as $item)
            <tr>
                <td>{{ $item->title }}</td>
                <td>{{ $item->publish_date }}</td>
                <td><img src="{{ $item->image_url }}" alt="週報圖片" style="max-width:120px;"></td>
                <td>
                    <a href="{{ route('admin.bulletins.edit', $item) }}" class="btn btn-sm btn-warning">編輯</a>
                    <form action="{{ route('admin.bulletins.destroy', $item) }}" method="POST" style="display:inline;">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger" onclick="return confirm('確定刪除？')">刪除</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {{ $bulletins->links() }}
</div>
@endsection
