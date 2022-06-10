<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(
            \App\Repositories\Interfaces\Auth\RegisterRepositoryInterface::class,
            \App\Repositories\Auth\RegisterEloquentRepository::class
        );
        $this->app->singleton(
            \App\Repositories\Interfaces\Auth\LoginRepositoryInterface::class,
            \App\Repositories\Auth\LoginEloquentRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
