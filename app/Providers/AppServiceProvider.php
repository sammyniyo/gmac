<?php

namespace App\Providers;

use App\Services\CartService;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(CartService::class, function () {
            return new CartService;
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        RateLimiter::for('contact', function (Request $request) {
            return [
                Limit::perMinute(3)->by($request->ip()),
                Limit::perHour(8)->by($request->ip()),
            ];
        });

        RateLimiter::for('checkout', function (Request $request) {
            return [
                Limit::perMinute(2)->by($request->ip()),
                Limit::perHour(5)->by($request->ip()),
            ];
        });

        RateLimiter::for('order-lookup', function (Request $request) {
            return [
                Limit::perMinute(6)->by($request->ip()),
                Limit::perHour(20)->by($request->ip()),
            ];
        });

        View::composer('layouts.frontend', function ($view) {
            $cart = app(CartService::class);
            $view->with('cartCount', $cart->count());
        });
    }
}
