<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;

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
        View::composer('partials.navbar', function ($view) {
            // Fetch cart items
            $cartItems = Auth::check() ? Auth::user()->cartItems : collect();

            // Fetch wishlist items
            $wishlistItems = Auth::check() ? Auth::user()->wishlist : collect();

            // Pass both variables to the view
            $view->with('cartItems', $cartItems)
                ->with('wishlistItems', $wishlistItems);
        });
    }
}
