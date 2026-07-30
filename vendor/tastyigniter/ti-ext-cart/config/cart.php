<?php

declare(strict_types=1);

use Igniter\Cart\Models\Cart;

return [

    /*
    |--------------------------------------------------------------------------
    | Cart database settings
    |--------------------------------------------------------------------------
    |
    | Here you can set the model that the cart should use when
    | storing and restoring a cart.
    |
    */

    'model' => Cart::class,

    /*
    |--------------------------------------------------------------------------
    | Destroy the cart on user logout
    |--------------------------------------------------------------------------
    |
    | When this option is set to 'true' the cart will automatically
    | destroy all cart instances when the user logs out.
    |
    */

    'destroyOnLogout' => false,

    'abandonedCart' => false,
];
