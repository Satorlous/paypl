<?php

namespace App\Providers;

use App\Good;
use App\Observers\GoodObserver;
use App\Observers\UserObserver;
use App\User;
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
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Good::observe(GoodObserver::class);
        User::observe(UserObserver::class);
    }
}
