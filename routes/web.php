<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ShowCategoryController;

Route::get('/', HomeController::class)->name('home');

Route::get('/blog', [PostController::class, 'index'])->name('posts.index');

Route::get('/category/{category:slug}', ShowCategoryController::class)->name('categories.show');

Route::get('/blog/{post:slug}', [PostController::class, 'show'])->name('posts.show');

Route::view('/about-us', 'about')->name('about');

Route::view('/privacy', 'privacy')->name('privacy');

Route::view('/policy', 'policy')->name('policy');

Route::view('/terms', 'terms')->name('terms');

Route::get('/{page:slug}', [PageController::class, 'show'])->name('pages.show');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    // Route::get('/dashboard', function () {
    //     return view('dashboard');
    // })->name('dashboard');
});
