@extends('layouts.front')

@section('title', '講道列表')

@section('content')
    <h1 class="mb-4">講道列表</h1>
    @component('components.search', ['action' => route('front.sermons')])@endcomponent
    @foreach($sermons as $sermon)
        @component('components.card', ['title' => $sermon->title, 'link' => route('front.sermons.show', $sermon->id)])
            {{ $sermon->speaker }} - {{ $sermon->sermon_date }}
        @endcomponent
    @endforeach
    @include('components.pagination', ['paginator' => $sermons])
@endsection
