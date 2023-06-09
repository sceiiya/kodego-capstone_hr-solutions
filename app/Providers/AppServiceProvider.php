<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

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
        Blade::if('admin', function () {
            return auth()->check() && auth()->user()->role == 'admin';
        });

        Blade::if('employee', function () {
            return auth()->check() && auth()->user()->role == 'employee';
        });

        Blade::if('applicant', function () {
            return auth()->check() && auth()->user()->role == 'applicant';
        });
    }
}
