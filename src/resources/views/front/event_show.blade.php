@extends('layouts.front')

@section('title', $event->title)

@section('content')
    <h1>{{ $event->title }}</h1>
    <p>時間：{{ $event->start_time }} @if($event->end_time) ~ {{ $event->end_time }}@endif</p>
    @if($event->location)
        <p>地點：{{ $event->location }}</p>
    @endif
    <div class="mb-3">{!! nl2br(e($event->content ?? '')) !!}</div>
    @if($event->image_url)
        <div class="mb-3">
            <img src="{{ $event->image_url }}" class="img-fluid" alt="{{ $event->title }}">
        </div>
    @endif
    <a href="{{ route('front.events') }}" class="btn btn-secondary">返回列表</a>
@endsection
