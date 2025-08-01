@extends('layouts.front')

@section('title', $group->name)

@section('content')
    <h1>{{ $group->name }}</h1>
    @if($group->type)
        <p>類型：{{ $group->type }}</p>
    @endif
    @if($group->contact_person)
        <p>聯絡人：{{ $group->contact_person }}</p>
    @endif
    <div class="mb-3">{!! nl2br(e($group->description ?? '')) !!}</div>
    @if($group->image_url)
        <div class="mb-3">
            <img src="{{ $group->image_url }}" class="img-fluid" alt="{{ $group->name }}">
        </div>
    @endif
    <a href="{{ route('front.groups') }}" class="btn btn-secondary">返回列表</a>
@endsection
