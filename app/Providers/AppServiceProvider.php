<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\View\Compilers\BladeCompiler;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $cartCount = '1';
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $cartCount = '1';
    }
}
