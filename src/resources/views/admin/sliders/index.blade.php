@extends('layouts.admin')
@section('content')
<div class="container py-4">
    <h2>輪播管理</h2>
    <a href="{{ route('admin.sliders.create') }}" class="btn btn-primary mb-3">新增輪播</a>
    <table class="table table-bordered">
        <thead><tr><th>標題</th><th>圖片</th><th>連結</th><th>排序</th><th>操作</th></tr></thead>
        <tbody>
        @foreach($sliders as $item)
            <tr>
                <td>{{ $item->title }}</td>
                <td><img src="{{ $item->image_url }}" alt="輪播圖片" style="max-width:120px;"></td>
                <td>{{ $item->link_url }}</td>
                <td>{{ $item->sort_order }}</td>
                <td>
                    <a href="{{ route('admin.sliders.edit', $item) }}" class="btn btn-sm btn-warning">編輯</a>
                    <form action="{{ route('admin.sliders.destroy', $item) }}" method="POST" style="display:inline;">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger" onclick="return confirm('確定刪除？')">刪除</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
