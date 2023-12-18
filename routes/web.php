<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');


Route::controller(PostController::class)
    ->prefix('blog')
    ->as('posts.')
    ->group(function () {
        Route::get('/', 'index')->name("index");
        Route::get('/{post:slug}', 'show')->name("show");
        Route::get('/category/{category:slug}', 'category')->name("category");
    });


//Route::get('/category/{category:slug}', ShowCategoryController::class)->name('categories.show');
//
//Route::get('/blog/{post:slug}', [PostController::class, 'show'])->name('posts.show');

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
