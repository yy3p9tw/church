@extends('layouts.front')

@section('title', '小組介紹')

@section('content')
    <h1 class="mb-4">小組介紹</h1>
    @component('components.search', ['action' => route('front.groups')])@endcomponent
    @foreach($groups as $group)
        @component('components.card', ['title' => $group->name, 'link' => route('front.groups.show', $group->id)])
            {{ $group->type }} @if($group->contact_person)｜聯絡人：{{ $group->contact_person }}@endif
        @endcomponent
    @endforeach
    @include('components.pagination', ['paginator' => $groups])
@endsection
