@extends('layouts.admin')
@section('content')
<div class="container py-4">
    <h2>活動管理</h2>
    <a href="{{ route('admin.events.create') }}" class="btn btn-primary mb-3">新增活動</a>
    <table class="table table-bordered">
        <thead><tr><th>標題</th><th>開始時間</th><th>結束時間</th><th>地點</th><th>操作</th></tr></thead>
        <tbody>
        @foreach($events as $event)
            <tr>
                <td>{{ $event->title }}</td>
                <td>{{ $event->start_time }}</td>
                <td>{{ $event->end_time }}</td>
                <td>{{ $event->location }}</td>
                <td>
                    <a href="{{ route('admin.events.edit', $event) }}" class="btn btn-sm btn-warning">編輯</a>
                    <form action="{{ route('admin.events.destroy', $event) }}" method="POST" style="display:inline;">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger" onclick="return confirm('確定刪除？')">刪除</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {{ $events->links() }}
</div>
@endsection
