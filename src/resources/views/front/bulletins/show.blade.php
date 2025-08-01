@extends('layouts.front')
@section('title', $bulletin->title)
@section('content')
<div class="container py-4">
    <a href="{{ route('front.bulletins') }}" class="btn btn-secondary mb-3">← 返回週報列表</a>
    <div class="text-center">
        <h2 class="mb-3">{{ $bulletin->title }}</h2>
        <p class="text-muted mb-4">{{ $bulletin->publish_date }}</p>
        <img src="{{ $bulletin->image_url }}" alt="週報圖片" class="img-fluid rounded shadow" style="max-width:100%;height:auto;">
    </div>
</div>
@endsection
