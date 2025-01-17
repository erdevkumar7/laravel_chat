<?php

namespace App\Providers;

use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
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
        view()->composer('*', function ($view) {
            $cartItems = [];
            $totalAmount = 0;
            $totalItemsInCart = 0;
    
            if (Auth::guard('web')->check()) {
                $cartItems = Cart::where('user_id', Auth::guard('web')->user()->id)->with('product')->get();
            } else {
                $sessionId = session()->getId();
                $cartItems = Cart::where('session_id', $sessionId)->with('product')->get();
            }
    
            $totalAmount = $cartItems->sum(fn($item) => $item->quantity * $item->product->price);
            $totalItemsInCart = count($cartItems);
            $view->with([
                'cartItems' => $cartItems,
                'cartTotal' => $totalAmount,
                'totalItemsInCart' => $totalItemsInCart,
            ]);
        });
    }
}
