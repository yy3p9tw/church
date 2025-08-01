@extends('layouts.front')
@section('title', $sermon->title)
@section('content')
<div class="container py-4">
    <a href="{{ route('front.sermons') }}" class="btn btn-secondary mb-3">← 返回講道列表</a>
    <h2>{{ $sermon->title }}</h2>
    <p class="text-muted">講員：{{ $sermon->speaker }}　日期：{{ $sermon->sermon_date }}</p>
    @if($sermon->video_url)
        <div class="ratio ratio-16x9 mb-4">
            <iframe src="https://www.youtube.com/embed/{{ Str::afterLast($sermon->video_url, 'v=') }}" title="YouTube 講道影片" allowfullscreen></iframe>
        </div>
    @endif
    <div class="mb-4">{!! nl2br(e($sermon->content)) !!}</div>
</div>
@endsection
