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
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if (config('app.env') === 'production' || env('APP_ENV') === 'production' || str_contains(request()->header('host', ''), 'onrender.com')) {
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }
    }
}
