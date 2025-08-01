@extends('layouts.admin')
@section('content')
<div class="container py-4">
    <h2>講道管理</h2>
    <a href="{{ route('admin.sermons.create') }}" class="btn btn-primary mb-3">新增講道</a>
    <table class="table table-bordered">
        <thead><tr><th>標題</th><th>講員</th><th>日期</th><th>操作</th></tr></thead>
        <tbody>
        @foreach($sermons as $sermon)
            <tr>
                <td>{{ $sermon->title }}</td>
                <td>{{ $sermon->speaker }}</td>
                <td>{{ $sermon->sermon_date }}</td>
                <td>
                    <a href="{{ route('admin.sermons.edit', $sermon) }}" class="btn btn-sm btn-warning">編輯</a>
                    <form action="{{ route('admin.sermons.destroy', $sermon) }}" method="POST" style="display:inline;">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger" onclick="return confirm('確定刪除？')">刪除</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {{ $sermons->links() }}
</div>
@endsection
