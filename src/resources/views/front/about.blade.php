@extends('layouts.front')
@section('title', '關於我們')
@section('content')
<div class="container py-5">
    <h1 class="fw-bold mb-5 text-center">關於我們</h1>
    <div class="mb-5">
        <h2 class="fw-bold mb-3 text-primary">我們的使命</h2>
        <div class="card shadow-sm p-4 mb-4">
            <p class="fs-5 mb-0">我們致力於傳揚福音、建立門徒、服事社區，讓每一個人都能經歷神的愛與真理，成為祝福的管道。</p>
        </div>
    </div>
    <div class="mb-5">
        <h2 class="fw-bold mb-3 text-primary">信仰宣告</h2>
        <div class="card shadow-sm p-4 mb-4">
            <ol class="fs-5 mb-0">
                <li>我們相信聖經是神所默示、信仰與生活最高準則。</li>
                <li>我們相信獨一真神，聖父、聖子、聖靈三位一體。</li>
                <li>我們相信耶穌基督為救主，因信稱義，得著永生。</li>
                <li>我們相信聖靈內住、引導、賜能力給信徒。</li>
                <li>我們相信教會是基督的身體，蒙召彼此相愛、同心合一。</li>
            </ol>
        </div>
    </div>
    <div class="mb-5">
        <h2 class="fw-bold mb-3 text-primary">我們的同工</h2>
        <div class="row g-4">
            <div class="col-12 col-md-4">
                <div class="card h-100 shadow-sm text-center">
                    <img src="/images/staff1.jpg" class="card-img-top mx-auto mt-3 rounded-circle" style="width:120px;height:120px;object-fit:cover;" alt="主任牧師">
                    <div class="card-body">
                        <h5 class="card-title">王大衛 主任牧師</h5>
                        <p class="card-text">負責教會異象、講道與牧養。</p>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="card h-100 shadow-sm text-center">
                    <img src="/images/staff2.jpg" class="card-img-top mx-auto mt-3 rounded-circle" style="width:120px;height:120px;object-fit:cover;" alt="行政同工">
                    <div class="card-body">
                        <h5 class="card-title">李以諾 行政同工</h5>
                        <p class="card-text">協助行政、活動與關懷事工。</p>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="card h-100 shadow-sm text-center">
                    <img src="/images/staff3.jpg" class="card-img-top mx-auto mt-3 rounded-circle" style="width:120px;height:120px;object-fit:cover;" alt="敬拜主領">
                    <div class="card-body">
                        <h5 class="card-title">張恩慈 敬拜主領</h5>
                        <p class="card-text">帶領敬拜團隊，服事主日聚會。</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
