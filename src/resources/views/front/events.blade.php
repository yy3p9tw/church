@extends('layouts.front')

@section('title', '活動行事曆')

@section('content')
    <h1 class="mb-4">活動行事曆</h1>
    @component('components.search', ['action' => route('front.events')])@endcomponent
    @foreach($events as $event)
        @component('components.card', ['title' => $event->title, 'link' => route('front.events.show', $event->id)])
            {{ $event->start_time }} @if($event->location)｜地點：{{ $event->location }}@endif
        @endcomponent
    @endforeach
    @include('components.pagination', ['paginator' => $events])
@endsection
