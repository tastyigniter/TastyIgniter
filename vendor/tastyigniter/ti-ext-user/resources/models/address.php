<?php

$config['form']['fields'] = [
    'address_id' => [
        'type' => 'hidden',
    ],
    'address_1' => [
        'label' => 'igniter.user::default.customers.label_address_1',
        'type' => 'text',
    ],
    'address_2' => [
        'label' => 'igniter.user::default.customers.label_address_2',
        'type' => 'text',
    ],
    'city' => [
        'label' => 'igniter.user::default.customers.label_city',
        'type' => 'text',
    ],
    'state' => [
        'label' => 'igniter.user::default.customers.label_state',
        'type' => 'text',
    ],
    'postcode' => [
        'label' => 'igniter.user::default.customers.label_postcode',
        'type' => 'text',
    ],
];

return $config;
