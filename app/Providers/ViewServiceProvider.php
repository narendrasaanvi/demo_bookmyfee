<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Session;
use App\Services\CartService;

class ViewServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $cartCount = '1';
    }

    public function register()
    {
        $cartCount = '1';
    }
}
