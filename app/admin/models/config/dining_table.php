<?php

return [
    'form' => [
        'fields' => [
            'id' => [
                'type' => 'hidden',
            ],
            'name' => [
                'label' => 'lang:admin::lang.label_name',
                'type' => 'text',
                'span' => 'left',
            ],
            'priority' => [
                'label' => 'lang:admin::lang.dining_tables.label_priority',
                'type' => 'number',
                'span' => 'right',
                'comment' => 'lang:admin::lang.dining_tables.help_priority',
            ],
            'dining_section_id' => [
                'label' => 'lang:admin::lang.dining_tables.column_section',
                'type' => 'select',
                'context' => 'edit',
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
            'extra_capacity' => [
                'label' => 'lang:admin::lang.dining_tables.label_extra_capacity',
                'type' => 'number',
                'span' => 'left',
                'comment' => 'lang:admin::lang.dining_tables.help_extra_capacity',
            ],
            'type' => [
                'label' => 'lang:admin::lang.dining_tables.label_table_shape',
                'type' => 'radiotoggle',
                'span' => 'right',
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
                'span' => 'left',
            ],
        ],
    ],
];
