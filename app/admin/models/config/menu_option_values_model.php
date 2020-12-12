<?php
$config['form'] = [
    'fields' => [
        'option_value_id' => [
            'type' => 'hidden',
        ],
        'option_id' => [
            'label' => 'lang:admin::lang.menu_options.label_option_id',
            'type' => 'hidden',
        ],
        'value' => [
            'label' => 'lang:admin::lang.menu_options.label_option_value',
            'type' => 'text',
        ],
        'price' => [
            'label' => 'lang:admin::lang.menu_options.label_option_price',
            'type' => 'currency',
        ],
        'allergens' => [
            'label' => 'lang:admin::lang.menus.label_allergens',
            'type' => 'relation',
            'span' => 'right',
            'attributes' => [
                'data-number-displayed' => 1,
            ],
        ],
        'priority' => [
            'label' => 'lang:admin::lang.menu_options.label_priority',
            'type' => 'hidden',
        ],
    ],
];

return $config;
