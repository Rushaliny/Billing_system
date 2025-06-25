<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;



class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
         URL::forceRootUrl(config('app.url')); // Add this line

    // If using HTTPS (e.g., Laravel on live site)
    // URL::forceScheme('https');
        //
    }
}
