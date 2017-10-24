<?php
$config['list']['filter'] = [
    'search' => [
        'prompt' => 'lang:admin::customer_online.text_filter_search',
        'mode'   => 'all' // or any, exact
    ],
    'scopes' => [
        'access'   => [
            'label' => 'lang:admin::customer_online.text_filter_access',
            'type'  => 'select',
            'conditions' => 'access_type = :filtered',
            'options'  => [
                'browser' => 'lang:admin::customer_online.text_browser',
                'mobile' => 'lang:admin::customer_online.text_mobile',
                'robot' => 'lang:admin::customer_online.text_robot',
            ],
        ],
        'date'   => [
            'label' => 'lang:admin::customer_online.text_filter_date',
            'type'  => 'date',
            'conditions' => 'YEAR(date_added) = :year AND MONTH(date_added) = :month',
            'modelClass' => 'Admin\Models\Customer_online_model',
            'options'    => 'getOnlineDates',
        ],
        'recent'   => [
            'label' => 'lang:admin::customer_online.text_filter_online',
            'type'  => 'checkbox',
            'scope' => 'isOnline',
        ],
    ],
];

$config['list']['toolbar'] = [
    'buttons' => [
        'option' => ['label' => 'lang:admin::default.button_option', 'class' => 'btn btn-default', 'href' => 'settings/edit/advanced'],
        'filter' => ['label' => 'lang:admin::default.button_icon_filter', 'class' => 'btn btn-default btn-filter', 'data-toggle' => 'list-filter', 'data-target' => '.panel-filter .panel-body'],
    ],
];

$config['list']['columns'] = [
    'ip_address'       => [
        'label'      => 'lang:admin::customer_online.column_ip',
        'type'       => 'text',
        'searchable' => TRUE,
    ],
    'country_name'       => [
        'label'      => 'lang:admin::customer_online.column_name',
        'type'       => 'text',
        'relation'       => 'country',
        'select'       => 'country_name',
        'searchable' => TRUE,
    ],
    'full_name'   => [
        'label'      => 'lang:admin::customer_online.column_customer',
        'relation'   => 'customer',
        'select'     => 'concat(first_name, " ", last_name)',
        'searchable' => TRUE,
    ],
    'access_type'       => [
        'label'      => 'lang:admin::customer_online.column_access',
        'type'       => 'text',
        'searchable' => TRUE,
    ],
    'browser'   => [
        'label' => 'lang:admin::customer_online.column_browser',
        'type'       => 'text',
        'searchable' => TRUE,
    ],
    'user_agent'      => [
        'label' => 'lang:admin::customer_online.column_agent',
        'type'       => 'text',
        'invisible' => TRUE,
    ],
    'request_uri'  => [
        'label' => 'lang:admin::customer_online.column_request_uri',
        'type'  => 'text',
    ],
    'referrer_uri'  => [
        'label' => 'lang:admin::customer_online.column_referrer_url',
        'type'  => 'text',
        'invisible' => TRUE,
    ],
    'date_added'      => [
        'label' => 'lang:admin::customer_online.column_last_activity',
        'type'  => 'timesince',
    ],
];

return $config;