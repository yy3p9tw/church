@extends('layouts.front')
@section('content')
<div class="container py-4">
    <h2>後台儀表板</h2>
    <div class="row">
        <div class="col-md-3">
            <div class="card mb-3">
                <div class="card-body text-center">
                    <h5 class="card-title">講道</h5>
                    <p class="card-text">@php echo App\Models\Sermon::count(); @endphp 筆</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card mb-3">
                <div class="card-body text-center">
                    <h5 class="card-title">消息</h5>
                    <p class="card-text">@php echo App\Models\News::count(); @endphp 筆</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card mb-3">
                <div class="card-body text-center">
                    <h5 class="card-title">活動</h5>
                    <p class="card-text">@php echo App\Models\Event::count(); @endphp 筆</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card mb-3">
                <div class="card-body text-center">
                    <h5 class="card-title">小組</h5>
                    <p class="card-text">@php echo App\Models\SmallGroup::count(); @endphp 筆</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
