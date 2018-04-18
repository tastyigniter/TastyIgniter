<?php
$config['list']['columns'] = [
    'date_added'      => [
        'label'      => 'lang:system::activities.column_date_added',
        'type'       => 'text',
        'searchable' => TRUE,
    ],
    'message'         => [
        'label'      => 'lang:system::activities.column_message',
        'type'       => 'text',
        'searchable' => TRUE,
    ],
    'status_for_name' => [
        'label'      => 'lang:system::activities.column_type',
        'type'       => 'text',
        'searchable' => TRUE,
    ],
    'notify_customer' => [
        'label' => 'lang:system::activities.column_notify',
        'type'  => 'switch',
    ],
    'activity_id'     => [
        'label'     => 'lang:admin::default.column_id',
        'invisible' => TRUE,
    ],

];

return $config;