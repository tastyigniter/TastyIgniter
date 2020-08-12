<?php
$config['form']['fields'] = [
    'address_id' => [
        'type' => 'hidden',
    ],
    'address_1' => [
        'label' => 'admin::lang.customers.label_address_1',
        'type' => 'text',
    ],
    'address_2' => [
        'label' => 'admin::lang.customers.label_address_2',
        'type' => 'text',
    ],
    'city' => [
        'label' => 'admin::lang.customers.label_city',
        'type' => 'text',
    ],
    'state' => [
        'label' => 'admin::lang.customers.label_state',
        'type' => 'text',
    ],
    'postcode' => [
        'label' => 'admin::lang.customers.label_postcode',
        'type' => 'text',
    ],
    'country_id' => [
        'label' => 'admin::lang.customers.label_country',
        'type' => 'select',
        'options' => [\System\Models\Countries_model::class, 'getDropdownOptions'],
    ],
];

return $config;
