@extends('layouts.front')
@section('title', '我們的同工')
@section('content')
<div class="container py-5">
    <h1 class="fw-bold mb-4 text-center">我們的同工</h1>
    <div class="row justify-content-center mb-5">
        <div class="col-md-10">
            <div class="row g-4">
                @foreach($staff as $item)
                <div class="col-12 col-md-4">
                    <div class="card h-100 shadow-sm text-center">
                        @if($item->photo)
                            <img src="{{ asset('storage/'.$item->photo) }}" class="card-img-top mx-auto mt-3 rounded-circle" style="width:120px;height:120px;object-fit:cover;" alt="{{ $item->title }}">
                        @else
                            <img src="https://placehold.co/120x120?text=No+Image" class="card-img-top mx-auto mt-3 rounded-circle" style="width:120px;height:120px;object-fit:cover;" alt="{{ $item->title }}">
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $item->name }} {{ $item->title }}</h5>
                            <p class="card-text">{{ $item->bio }}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
