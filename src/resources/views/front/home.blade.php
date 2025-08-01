
@php
    use Illuminate\Support\Str;
@endphp
@extends('layouts.front')

@section('title', '教會首頁')

@section('content')
<div class="container py-4">
    <!-- 輪播區塊（後台管理） -->
    @if($sliders->count())
    <div id="welcomeCarousel" class="carousel slide mb-5 slider-fullscreen" data-bs-ride="carousel">
        <div class="carousel-inner">
            @foreach($sliders as $i => $slider)
                <div class="carousel-item @if($i === 0) active @endif">
                    @if($slider->link_url)
                        <a href="{{ $slider->link_url }}" target="_blank"><img src="{{ $slider->image_url }}" class="d-block slider-img" alt="{{ $slider->title }}"></a>
                    @else
                        <img src="{{ $slider->image_url }}" class="d-block slider-img" alt="{{ $slider->title }}">
                    @endif
                    @if($slider->title)
                        <div class="carousel-caption d-none d-md-block bg-dark bg-opacity-50 rounded p-3">
                            <h2 class="fw-bold">{{ $slider->title }}</h2>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#welcomeCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#welcomeCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
        </button>
    </div>
    @endif

    <!-- 主日時間地點地圖 -->
    <div class="row mb-5 align-items-center">
        <div class="col-md-6 mb-3 mb-md-0">
            <h3 class="fw-bold">主日聚會</h3>
            <p class="mb-1">每週日 10:00</p>
            <p class="mb-1">台北市信義區松仁路100號</p>
        </div>
        <div class="col-md-6">
            <iframe src="https://www.google.com/maps?q=台北市信義區松仁路100號&output=embed" width="100%" height="220" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
        </div>
    </div>

    <!-- 我們的事工 -->
    <div class="mb-5">
        <h3 class="fw-bold mb-3">我們的事工</h3>
        <div class="row g-4">
            @foreach($groups->take(2) as $group)
                <div class="col-12 col-md-6">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">{{ $group->name }}</h5>
                            <p class="card-text">{{ $group->description }}</p>
                            <a href="{{ url('/groups/'.$group->id) }}" class="btn btn-outline-primary">了解更多</a>
                        </div>
                    </div>
                </div>
            @endforeach
            @foreach($events->take(2) as $event)
                <div class="col-12 col-md-6">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">{{ $event->title }}</h5>
                            <p class="card-text">{{ $event->start_time }}<br>{{ $event->location }}</p>
                            <a href="{{ url('/events/'.$event->id) }}" class="btn btn-outline-primary">活動詳情</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- 主日訊息講道（最新3筆） -->
    <div class="mb-5">
        <h3 class="fw-bold mb-3">主日訊息講道</h3>
        <div class="row g-4">
            @foreach($sermons->take(3) as $sermon)
                <div class="col-12 col-md-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">{{ $sermon->title }}</h5>
                            <p class="card-text">講員：{{ $sermon->speaker }}<br>日期：{{ $sermon->sermon_date }}</p>
                            <a href="{{ url('/sermons/'.$sermon->id) }}" class="btn btn-outline-primary">觀看內容</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- 最新消息 -->
    <div class="mb-5">
        <h3 class="fw-bold mb-3">最新消息</h3>
        <ul class="list-group">
            @foreach($news->take(5) as $item)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span>{{ $item->title }}</span>
                    <a href="{{ url('/news/'.$item->id) }}" class="btn btn-sm btn-outline-secondary">查看</a>
                </li>
            @endforeach
        </ul>
    </div>
</div>
@endsection
