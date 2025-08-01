@extends('layouts.front')

@section('title', $sermon->title)

@section('content')
    <h1>{{ $sermon->title }}</h1>
    <p>講員：{{ $sermon->speaker }}　日期：{{ $sermon->sermon_date }}</p>
    <div class="mb-3">{!! nl2br(e($sermon->content)) !!}</div>
    @if($sermon->video_url)
        <div class="mb-3">
            @if(Str::contains($sermon->video_url, 'youtube.com') || Str::contains($sermon->video_url, 'youtu.be'))
                <div class="ratio ratio-16x9">
                    <iframe src="https://www.youtube.com/embed/{{ Str::contains($sermon->video_url, 'v=') ? Str::after($sermon->video_url, 'v=') : Str::afterLast($sermon->video_url, '/') }}" allowfullscreen></iframe>
                </div>
            @else
                <video src="{{ $sermon->video_url }}" controls width="100%"></video>
            @endif
        </div>
    @endif
    @if($sermon->audio_url)
        <div class="mb-3">
            <audio src="{{ $sermon->audio_url }}" controls></audio>
        </div>
    @endif
    <a href="{{ route('front.sermons') }}" class="btn btn-secondary">返回列表</a>
@endsection
