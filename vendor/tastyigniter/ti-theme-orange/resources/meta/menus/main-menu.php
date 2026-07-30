<?php

declare(strict_types=1);

return [
    'name' => 'Main menu',
    'items' => [
        [
            'title' => 'igniter.orange::default.menu_menu',
            'code' => 'view-menu',
            'type' => 'theme-page',
            'reference' => 'local.menus',
        ],
        [
            'title' => 'igniter.orange::default.menu_reservation',
            'code' => 'reservation',
            'type' => 'theme-page',
            'reference' => 'reservation.reservation',
        ],
        [
            'title' => 'igniter.orange::default.menu_login',
            'code' => 'login',
            'type' => 'theme-page',
            'reference' => 'account.login',
        ],
        [
            'title' => 'igniter.orange::default.menu_register',
            'code' => 'register',
            'type' => 'theme-page',
            'reference' => 'account.register',
        ],
        [
            'title' => 'igniter.orange::default.menu_my_account',
            'code' => 'account',
            'type' => 'theme-page',
            'reference' => 'account.account',
            'items' => [
                [
                    'title' => 'igniter.orange::default.menu_recent_order',
                    'code' => 'recent-orders',
                    'type' => 'theme-page',
                    'reference' => 'account.orders',
                ],
                [
                    'title' => 'igniter.orange::default.menu_my_account',
                    'code' => '',
                    'type' => 'theme-page',
                    'reference' => 'account.account',
                ],
                [
                    'title' => 'igniter.orange::default.menu_address',
                    'code' => '',
                    'type' => 'theme-page',
                    'reference' => 'account.address',
                ],
                [
                    'title' => 'igniter.orange::default.menu_recent_reservation',
                    'code' => '',
                    'type' => 'theme-page',
                    'reference' => 'account.reservations',
                ],
                [
                    'title' => 'igniter.orange::default.menu_logout',
                    'code' => '',
                    'type' => 'url',
                    'url' => '/logout',
                ],
            ],
        ],
    ],
];
