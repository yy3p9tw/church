<form class="d-flex mb-3" method="GET" action="{{ $action ?? url()->current() }}">
    <input type="text" name="q" class="form-control me-2" placeholder="搜尋..." value="{{ request('q') }}">
    <button class="btn btn-outline-primary" type="submit">搜尋</button>
</form>
