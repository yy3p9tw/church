@extends('layouts.front')
@section('title', '週報')
@section('content')
<div class="container py-4">
    <h2 class="mb-4">週報</h2>
    <div class="row g-4">
        @foreach($bulletins as $item)
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card h-100">
                    <a href="{{ route('front.bulletins.show', $item->id) }}">
                        <img src="{{ $item->image_url }}" class="card-img-top" alt="週報圖片" style="transition:0.2s;cursor:zoom-in;">
                    </a>
                    <div class="card-body">
                        <h5 class="card-title">
                            <a href="{{ route('front.bulletins.show', $item->id) }}" class="text-decoration-none">{{ $item->title }}</a>
                        </h5>
                        <p class="card-text text-muted">{{ $item->publish_date }}</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="mt-4">{{ $bulletins->links() }}</div>
</div>
@endsection
