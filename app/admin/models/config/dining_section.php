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
                'label' => 'lang:admin::lang.dining_tables.label_priority',
                'type' => 'number',
                'comment' => 'lang:admin::lang.dining_areas.help_section_priority',
            ],
            'description' => [
                'label' => 'lang:admin::lang.label_description',
                'type' => 'textarea',
            ],
            'is_enabled' => [
                'label' => 'lang:admin::lang.dining_areas.label_is_enabled',
                'type' => 'switch',
                'default' => true,
            ],
        ],
    ],
];
