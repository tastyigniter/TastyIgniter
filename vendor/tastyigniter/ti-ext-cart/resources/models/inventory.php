<?php

$config['list']['filter'] = [
    'search' => [
        'prompt' => 'lang:igniter.cart::default.stocks.text_filter_search',
        'mode' => 'all',
    ],
    'scopes' => [],
];

$config['list']['toolbar'] = [];

$config['list']['bulkActions'] = [
    'out_of_stock' => [
        'label' => 'lang:igniter.cart::default.stocks.button_out_of_stock',
        'class' => 'btn btn-light',
        'data-request-confirm' => 'lang:igniter.cart::default.stocks.alert_warning_confirm',
    ],
];

$config['list']['columns'] = [
    'id' => [
        'label' => 'lang:igniter.cart::default.stocks.column_id',
        'type' => 'text',
        'searchable' => true,
    ],
    'stockable_type_name' => [
        'label' => 'lang:igniter.cart::default.stocks.column_stockable_type',
        'type' => 'text',
        'select' => 'stockable_type',
        'searchable' => false,
    ],
    'stockable_name' => [
        'label' => 'lang:igniter.cart::default.stocks.column_stockable_name',
        'type' => 'text',
    ],
    'location_name' => [
        'label' => 'lang:igniter::admin.column_location',
        'type' => 'text',
        'relation' => 'location',
        'select' => 'location_name',
        'locationAware' => true,
    ],
    'low_stock_threshold' => [
        'label' => 'lang:igniter.cart::default.stocks.column_low_stock_threshold',
        'type' => 'text',
    ],
    'quantity' => [
        'label' => 'lang:igniter.cart::default.stocks.column_quantity',
        'type' => 'number',
    ],
    'out_of_stock_status' => [
        'label' => 'lang:igniter.cart::default.stocks.column_stock_status',
        'type' => 'partial',
        'path' => 'inventory/stock_status_column',
        'sortable' => false,
        'searchable' => false,
        'cssClass' => 'overflow-visible',
    ],
];

return $config;
