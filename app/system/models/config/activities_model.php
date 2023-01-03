<?php
$config['list']['columns'] = [
    'created_at' => [
        'label' => 'lang:admin::lang.column_date_added',
        'type' => 'text',
        'searchable' => true,
    ],
    'message' => [
        'label' => 'lang:system::lang.activities.column_message',
        'type' => 'text',
        'searchable' => true,
    ],
    'status_for_name' => [
        'label' => 'lang:admin::lang.label_type',
        'type' => 'text',
        'searchable' => true,
    ],
    'notify_customer' => [
        'label' => 'lang:system::lang.activities.column_notify',
        'type' => 'switch',
    ],
    'activity_id' => [
        'label' => 'lang:admin::lang.column_id',
        'invisible' => true,
    ],

];

return $config;
