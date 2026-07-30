<?php

declare(strict_types=1);

use Igniter\User\Models\Customer;
use Igniter\User\Models\User;

return [

    'passwords' => [
        'resets' => config('auth.defaults.passwords'),
        'activations' => config('auth.defaults.passwords'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Authentication Guards
    |--------------------------------------------------------------------------
    |
    | By default, TastyIgniter will use the `web` authentication guard. However,
    | if you want to run TastyIgniter alongside the default Laravel auth
    | guard, you can configure that for your admin and/or site.
    |
    */

    'guards' => [
        'admin' => 'igniter-admin',
        'web' => 'igniter-customer',
    ],

    'mergeGuards' => [
        'igniter-admin' => [
            'driver' => 'igniter-admin',
            'provider' => 'igniter-admin',
        ],
        'igniter-customer' => [
            'driver' => 'igniter-customer',
            'provider' => 'igniter',
        ],
    ],

    'mergeProviders' => [
        'igniter-admin' => [
            'driver' => 'igniter',
            'model' => User::class,
        ],
        'igniter' => [
            'driver' => 'igniter',
            'model' => Customer::class,
        ],
    ],
];
