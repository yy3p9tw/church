@extends('layouts.front')

@section('title', $news->title)

@section('content')
    <h1>{{ $news->title }}</h1>
    <p>發布日期：{{ $news->news_date ?? $news->publish_date }}</p>
    <div class="mb-3">{!! nl2br(e($news->content)) !!}</div>
    @if($news->image_url)
        <div class="mb-3">
            <img src="{{ $news->image_url }}" class="img-fluid" alt="{{ $news->title }}">
        </div>
    @endif
    <a href="{{ route('front.news') }}" class="btn btn-secondary">返回列表</a>
@endsection
