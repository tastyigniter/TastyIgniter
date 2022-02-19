<?php
$config['list']['columns'] = [
    'created_at' => [
        'label' => 'lang:admin::lang.column_date_added',
        'type' => 'text',
        'searchable' => TRUE,
    ],
    'message' => [
        'label' => 'lang:system::lang.activities.column_message',
        'type' => 'text',
        'searchable' => TRUE,
    ],
    'status_for_name' => [
        'label' => 'lang:admin::lang.label_type',
        'type' => 'text',
        'searchable' => TRUE,
    ],
    'notify_customer' => [
        'label' => 'lang:system::lang.activities.column_notify',
        'type' => 'switch',
    ],
    'activity_id' => [
        'label' => 'lang:admin::lang.column_id',
        'invisible' => TRUE,
    ],

];

return $config;
