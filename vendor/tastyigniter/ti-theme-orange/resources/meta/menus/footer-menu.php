<?php

declare(strict_types=1);

return [
    'name' => 'Footer menu',
    'items' => [
        [
            'title' => 'igniter.orange::default.text_restaurant',
            'code' => '',
            'type' => 'header',
            'items' => [
                [
                    'title' => 'igniter.orange::default.menu_menu',
                    'code' => '',
                    'type' => 'theme-page',
                    'reference' => 'local.menus',
                ],
                [
                    'title' => 'igniter.orange::default.menu_reservation',
                    'code' => '',
                    'type' => 'theme-page',
                    'reference' => 'reservation.reservation',
                ],
                [
                    'title' => 'igniter.orange::default.menu_locations',
                    'code' => '',
                    'type' => 'theme-page',
                    'reference' => 'locations',
                ],
            ],
        ],
        [
            'title' => 'igniter.orange::default.text_information',
            'code' => '',
            'type' => 'header',
            'items' => [
                [
                    'title' => 'igniter.orange::default.menu_contact',
                    'code' => '',
                    'type' => 'theme-page',
                    'reference' => 'contact',
                ],
                [
                    'title' => 'About Us',
                    'code' => '',
                    'type' => 'static-page',
                    'reference' => 'about-us',
                ],
                [
                    'title' => 'Privacy Policy',
                    'code' => '',
                    'type' => 'static-page',
                    'reference' => 'policy',
                ],
            ],
        ],
    ],
];
