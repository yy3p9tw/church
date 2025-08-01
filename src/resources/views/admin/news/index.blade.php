@extends('layouts.admin')
@section('content')
<div class="container py-4">
    <h2>消息管理</h2>
    <a href="{{ route('admin.news.create') }}" class="btn btn-primary mb-3">新增消息</a>
    <table class="table table-bordered">
        <thead><tr><th>標題</th><th>日期</th><th>操作</th></tr></thead>
        <tbody>
        @foreach($news as $item)
            <tr>
                <td>{{ $item->title }}</td>
                <td>{{ $item->news_date }}</td>
                <td>
                    <a href="{{ route('admin.news.edit', $item) }}" class="btn btn-sm btn-warning">編輯</a>
                    <form action="{{ route('admin.news.destroy', $item) }}" method="POST" style="display:inline;">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger" onclick="return confirm('確定刪除？')">刪除</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {{ $news->links() }}
</div>
@endsection
