@extends('layouts.front')
@section('title', '聯絡我們')
@section('content')
    <div class="d-flex flex-column align-items-center justify-content-center" style="min-height:60vh;">
        <h1 class="mb-4">聯絡我們</h1>
        <div class="card shadow-sm mb-4 w-100" style="max-width:520px;">
            <div class="card-body">
            <ul class="list-unstyled mb-3">
                <li class="mb-2"><span style="font-size:1.2em;">📞</span> <strong>電話：</strong> <a href="tel:0212345678">(02) 1234-5678</a></li>
                <li class="mb-2"><span style="font-size:1.2em;">💬</span> <strong>Line：</strong> <a href="https://line.me/ti/p/@churchline" target="_blank">@churchline</a></li>
                <li class="mb-2"><span style="font-size:1.2em;">📸</span> <strong>Instagram：</strong> <a href="https://instagram.com/churchig" target="_blank">@churchig</a></li>
                <li class="mb-2"><span style="font-size:1.2em;">📘</span> <strong>Facebook：</strong> <a href="https://facebook.com/churchfb" target="_blank">教會FB粉專</a></li>
                <li class="mb-2"><span style="font-size:1.2em;">📍</span> <strong>地址：</strong> 台北市信義區仁愛路100號</li>
                <li class="mb-2"><span style="font-size:1.2em;">✉️</span> <strong>Email：</strong> <a href="mailto:info@church.org">info@church.org</a></li>
            </ul>
            <hr>
            <div class="ratio ratio-16x9 rounded shadow-sm overflow-hidden">
                <iframe src="https://www.google.com/maps?q=台北市信義區仁愛路100號&output=embed" width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
            </div>
        </div>
    </div>
@endsection
