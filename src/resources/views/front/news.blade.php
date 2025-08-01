
@php
    use Illuminate\Support\Str;
@endphp
@extends('layouts.front')

@section('title', '消息公告')

@section('content')
    <h1 class="mb-4">消息公告</h1>
    @component('components.search', ['action' => route('front.news')])@endcomponent
    @foreach($news as $item)
        @component('components.card', ['title' => $item->title, 'link' => route('front.news.show', $item->id)])
            {{ Str::limit($item->content, 50) }}
        @endcomponent
    @endforeach
    @include('components.pagination', ['paginator' => $news])
@endsection
