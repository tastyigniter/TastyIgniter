<?php

$config['list']['filter'] = [
    'search' => [
        'prompt' => 'lang:igniter.coupons::default.text_filter_search',
        'mode' => 'all',
    ],
];

$config['list']['columns'] = [
    'created_at' => [
        'label' => 'lang:igniter.coupons::default.column_date_used',
        'type' => 'timetense',
    ],
    'coupon_name' => [
        'label' => 'lang:admin::lang.label_name',
        'relation' => 'coupon',
        'select' => 'name',
        'searchable' => true,
    ],
    'code' => [
        'label' => 'lang:igniter.coupons::default.column_code',
        'searchable' => true,
    ],
    'order_id' => [
        'label' => 'lang:igniter.coupons::default.column_order_id',
        'searchable' => true,
    ],
    'customer_name' => [
        'label' => 'lang:igniter.coupons::default.column_customer',
        'relation' => 'customer',
        'select' => 'concat(first_name, " ", last_name)',
        'searchable' => true,
    ],
    'min_total' => [
        'label' => 'lang:igniter.coupons::default.column_min_total',
        'type' => 'currency',
    ],
    'amount' => [
        'label' => 'lang:igniter.coupons::default.column_amount',
        'type' => 'currency',
    ],
    'order_total' => [
        'label' => 'lang:igniter.coupons::default.column_total',
        'type' => 'currency',
    ],
    'coupon_history_id' => [
        'label' => 'lang:admin::lang.column_id',
        'invisible' => true,
    ],
];

return $config;
