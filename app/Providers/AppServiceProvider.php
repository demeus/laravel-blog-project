<?php

namespace App\Providers;

use App\Repositories\PostRepository;
use Illuminate\Support\ServiceProvider;
use App\Repositories\Contracts\PostRepositoryContract;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register() : void
    {
        $this->app->bind(PostRepositoryContract::class, PostRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot() : void
    {
        //
    }
}
