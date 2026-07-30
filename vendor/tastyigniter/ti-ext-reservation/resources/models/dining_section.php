<?php

return [
    'form' => [
        'fields' => [
            'location_id' => [
                'type' => 'hidden',
            ],
            'name' => [
                'label' => 'lang:admin::lang.label_name',
                'type' => 'text',
            ],
            'priority' => [
                'label' => 'lang:igniter.reservation::default.dining_tables.label_priority',
                'type' => 'select',
                'default' => 0,
                'comment' => 'lang:igniter.reservation::default.dining_areas.help_section_priority',
            ],
            'description' => [
                'label' => 'lang:admin::lang.label_description',
                'type' => 'textarea',
            ],
            'is_enabled' => [
                'label' => 'lang:igniter.reservation::default.dining_areas.label_is_enabled',
                'type' => 'switch',
                'default' => true,
            ],
        ],
    ],
];
