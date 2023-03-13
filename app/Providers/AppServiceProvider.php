<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(\App\Interfaces\AuthorInterface::class, \App\Repositories\AuthorRepository::class);
        $this->app->bind(\App\Interfaces\VirusInterface::class, \App\Repositories\VirusRepository::class);
        $this->app->bind(\App\Interfaces\GenotipeInterface::class, \App\Repositories\GenotipeRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
