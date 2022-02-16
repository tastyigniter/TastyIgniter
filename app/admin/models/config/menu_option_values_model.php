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
        'stock_qty' => [
            'label' => 'lang:admin::lang.menus.label_stock_qty',
            'type' => 'stockeditor',
            'span' => 'right',
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
    'rules' => [
        ['option_id', 'lang:admin::lang.menu_options.label_option_id', 'required|integer'],
        ['value', 'lang:admin::lang.menu_options.label_option_value', 'required|min:2|max:128'],
        ['price', 'lang:admin::lang.menu_options.label_option_price', 'required|numeric|min:0'],
        ['priority', 'lang:admin::lang.menu_options.label_option_price', 'integer'],
        ['allergens.*', 'lang:admin::lang.menus.label_allergens', 'integer'],
    ],
];

return $config;
