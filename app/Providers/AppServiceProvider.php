<?php

namespace App\Providers;

use App\Models\Category;
use App\Repositories\Contracts\PostRepositoryContract;
use App\Repositories\PostRepository;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(PostRepositoryContract::class, PostRepository::class);

        View::composer('posts.partials.categories-box', function ($view) {
            $categories ??= Cache::remember('categories', now()->addDays(3), function () {
                return Category::query()->whereHas('posts', function ($query) {
                    $query->published();
                })->orderBy('name')->take(10)->get();
            });


            $view->with(compact('categories'));
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
