<?php

return [
    'form' => [
        'fields' => [
            'id' => [
                'type' => 'hidden',
            ],
            'priority' => [
                'type' => 'hidden',
            ],
            'name' => [
                'label' => 'lang:admin::lang.label_name',
                'type' => 'text',
                'attributes' => [
                    'readonly' => 'readonly',
                ],
            ],
            'min_capacity' => [
                'label' => 'lang:admin::lang.dining_tables.label_min_capacity',
                'type' => 'number',
                'span' => 'left',
            ],
            'max_capacity' => [
                'label' => 'lang:admin::lang.dining_tables.label_capacity',
                'type' => 'number',
                'span' => 'right',
            ],
            'type' => [
                'label' => 'lang:admin::lang.dining_tables.label_table_shape',
                'type' => 'radiotoggle',
                'default' => 'rectangle',
                'options' => [
                    'rectangle' => 'lang:admin::lang.dining_tables.text_rectangle',
                    'round' => 'lang:admin::lang.dining_tables.text_round',
                ],
                'comment' => 'lang:admin::lang.dining_tables.help_table_shape',
            ],
            'is_enabled' => [
                'label' => 'lang:admin::lang.dining_tables.label_is_enabled',
                'type' => 'switch',
                'default' => true,
            ],
        ],
    ],
];
