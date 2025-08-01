
<?php

// 前台靜態頁面：我們的使命、信仰宣告、我們的同工
Route::view('/mission', 'front.mission')->name('mission');
Route::view('/belief', 'front.belief')->name('belief');
Route::get('/staff', [App\Http\Controllers\Front\StaffController::class, 'index'])->name('staff');

// 前台靜態頁面：關於我們
Route::view('/about', 'front.about')->name('about');

// 前台靜態頁面：我們的使命、信仰宣告、我們的同工

use Illuminate\Support\Facades\Route;

// 前台聯絡
Route::get('/contact', [App\Http\Controllers\Front\HomeController::class, 'contact'])->name('front.contact');


// 前台首頁
Route::get('/', [App\Http\Controllers\Front\HomeController::class, 'index'])->name('front.home');

// 前台講道列表/單篇
Route::get('/sermons', [App\Http\Controllers\Front\HomeController::class, 'sermons'])->name('front.sermons');
Route::get('/sermons/{id}', [App\Http\Controllers\Front\HomeController::class, 'sermonShow'])->name('front.sermons.show');

// 前台消息
Route::get('/news', [App\Http\Controllers\Front\HomeController::class, 'news'])->name('front.news');
Route::get('/news/{id}', [App\Http\Controllers\Front\HomeController::class, 'newsShow'])->name('front.news.show');

// 前台活動
Route::get('/events', [App\Http\Controllers\Front\HomeController::class, 'events'])->name('front.events');
Route::get('/events/{id}', [App\Http\Controllers\Front\HomeController::class, 'eventShow'])->name('front.events.show');

// 前台小組

// 前台週報
Route::get('/bulletins', [App\Http\Controllers\Front\BulletinController::class, 'index'])->name('front.bulletins');
Route::get('/bulletins/{id}', [App\Http\Controllers\Front\BulletinController::class, 'show'])->name('front.bulletins.show');
// 前台小組
Route::get('/groups', [App\Http\Controllers\Front\HomeController::class, 'groups'])->name('front.groups');
Route::get('/groups/{id}', [App\Http\Controllers\Front\HomeController::class, 'groupShow'])->name('front.groups.show');

// 後台儀表板（僅示範）
Route::get('/admin', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('admin.dashboard');

// 後台管理：講道、小組、消息、活動
Route::prefix('admin')->name('admin.')->group(function () {
    // 同工 CRUD
    Route::resource('staff', App\Http\Controllers\Admin\StaffController::class);
    // 輪播 CRUD
    Route::get('sliders', [App\Http\Controllers\Admin\SliderController::class, 'index'])->name('sliders.index');
    Route::get('sliders/create', [App\Http\Controllers\Admin\SliderController::class, 'create'])->name('sliders.create');
    Route::post('sliders', [App\Http\Controllers\Admin\SliderController::class, 'store'])->name('sliders.store');
    Route::get('sliders/{slider}/edit', [App\Http\Controllers\Admin\SliderController::class, 'edit'])->name('sliders.edit');
    Route::put('sliders/{slider}', [App\Http\Controllers\Admin\SliderController::class, 'update'])->name('sliders.update');
    Route::delete('sliders/{slider}', [App\Http\Controllers\Admin\SliderController::class, 'destroy'])->name('sliders.destroy');
    Route::get('sermons', [App\Http\Controllers\Admin\SermonController::class, 'index'])->name('sermons.index');
    Route::get('sermons/create', [App\Http\Controllers\Admin\SermonController::class, 'create'])->name('sermons.create');
    Route::post('sermons', [App\Http\Controllers\Admin\SermonController::class, 'store'])->name('sermons.store');
    Route::get('sermons/{sermon}/edit', [App\Http\Controllers\Admin\SermonController::class, 'edit'])->name('sermons.edit');
    Route::put('sermons/{sermon}', [App\Http\Controllers\Admin\SermonController::class, 'update'])->name('sermons.update');
    Route::delete('sermons/{sermon}', [App\Http\Controllers\Admin\SermonController::class, 'destroy'])->name('sermons.destroy');
    Route::get('groups', [App\Http\Controllers\Admin\GroupController::class, 'index'])->name('groups.index');
    Route::get('groups/create', [App\Http\Controllers\Admin\GroupController::class, 'create'])->name('groups.create');
    Route::post('groups', [App\Http\Controllers\Admin\GroupController::class, 'store'])->name('groups.store');
    Route::get('groups/{group}/edit', [App\Http\Controllers\Admin\GroupController::class, 'edit'])->name('groups.edit');
    Route::put('groups/{group}', [App\Http\Controllers\Admin\GroupController::class, 'update'])->name('groups.update');
    Route::delete('groups/{group}', [App\Http\Controllers\Admin\GroupController::class, 'destroy'])->name('groups.destroy');
    Route::get('news', [App\Http\Controllers\Admin\NewsController::class, 'index'])->name('news.index');
    Route::get('news/create', [App\Http\Controllers\Admin\NewsController::class, 'create'])->name('news.create');
    Route::post('news', [App\Http\Controllers\Admin\NewsController::class, 'store'])->name('news.store');
    Route::get('news/{news}/edit', [App\Http\Controllers\Admin\NewsController::class, 'edit'])->name('news.edit');
    Route::put('news/{news}', [App\Http\Controllers\Admin\NewsController::class, 'update'])->name('news.update');
    Route::delete('news/{news}', [App\Http\Controllers\Admin\NewsController::class, 'destroy'])->name('news.destroy');
    Route::get('events', [App\Http\Controllers\Admin\EventController::class, 'index'])->name('events.index');
    Route::get('events/create', [App\Http\Controllers\Admin\EventController::class, 'create'])->name('events.create');
    Route::post('events', [App\Http\Controllers\Admin\EventController::class, 'store'])->name('events.store');
    Route::get('events/{event}/edit', [App\Http\Controllers\Admin\EventController::class, 'edit'])->name('events.edit');
    Route::put('events/{event}', [App\Http\Controllers\Admin\EventController::class, 'update'])->name('events.update');
    Route::delete('events/{event}', [App\Http\Controllers\Admin\EventController::class, 'destroy'])->name('events.destroy');

    // 週報 CRUD
    Route::get('bulletins', [App\Http\Controllers\Admin\BulletinController::class, 'index'])->name('bulletins.index');
    Route::get('bulletins/create', [App\Http\Controllers\Admin\BulletinController::class, 'create'])->name('bulletins.create');
    Route::post('bulletins', [App\Http\Controllers\Admin\BulletinController::class, 'store'])->name('bulletins.store');
    Route::get('bulletins/{bulletin}/edit', [App\Http\Controllers\Admin\BulletinController::class, 'edit'])->name('bulletins.edit');
    Route::put('bulletins/{bulletin}', [App\Http\Controllers\Admin\BulletinController::class, 'update'])->name('bulletins.update');
    Route::delete('bulletins/{bulletin}', [App\Http\Controllers\Admin\BulletinController::class, 'destroy'])->name('bulletins.destroy');
});
