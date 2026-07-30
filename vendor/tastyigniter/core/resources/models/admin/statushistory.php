<?php

$config['list']['columns'] = [
    'created_at' => [
        'label' => 'lang:igniter::admin.statuses.column_time_date',
        'type' => 'timetense',
    ],
    'staff_name' => [
        'label' => 'lang:igniter::admin.statuses.column_staff',
        'relation' => 'staff',
        'select' => 'name',
    ],
    'status' => [
        'label' => 'lang:igniter::admin.label_status',
        'relation' => 'status',
        'select' => 'status_name',
    ],
    'comment' => [
        'label' => 'lang:igniter::admin.statuses.column_comment',
    ],
    'notified' => [
        'label' => 'lang:igniter::admin.statuses.column_notify',
    ],
    'updated_at' => [
        'label' => 'lang:igniter::admin.column_date_updated',
        'invisible' => true,
        'type' => 'datetime',
    ],
];

return $config;
