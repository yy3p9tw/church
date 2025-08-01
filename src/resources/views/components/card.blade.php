<div class="card mb-3">
    <div class="card-body">
        <h5 class="card-title">{{ $title ?? '' }}</h5>
        <p class="card-text">{{ $slot }}</p>
        @if(isset($link))
            <a href="{{ $link }}" class="btn btn-primary">詳細</a>
        @endif
    </div>
</div>
