<?php

declare(strict_types=1);

namespace Igniter\Cart\Http\Middleware;

use Closure;
use Igniter\Cart\Facades\Cart;
use Igniter\Local\Facades\Location;
use Igniter\User\Facades\Auth;

class CartMiddleware
{
    public function handle($request, Closure $next)
    {
        if (Location::current()) {
            Cart::instance('location-'.Location::getId());
        }

        return $next($request);
    }

    public function terminate($request, $response): void
    {
        if (config('igniter-cart.abandonedCart')) {
            $this->storeUserCart();
        }
    }

    protected function storeUserCart()
    {
        if (!Auth::check()) {
            return;
        }

        if (Cart::content()->isEmpty()) {
            return;
        }

        Cart::store(Auth::getUser()->getKey());
    }
}
