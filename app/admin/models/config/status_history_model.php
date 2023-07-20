<?php

$config['list']['columns'] = [
    'created_at' => [
        'label' => 'lang:admin::lang.statuses.column_time_date',
        'type' => 'timetense',
    ],
    'staff_name' => [
        'label' => 'lang:admin::lang.statuses.column_staff',
        'relation' => 'staff',
        'select' => 'staff_name',
    ],
    'status_name' => [
        'label' => 'lang:admin::lang.label_status',
        'relation' => 'status',
        'select' => 'status_name',
    ],
    'comment' => [
        'label' => 'lang:admin::lang.statuses.column_comment',
    ],
    'notified' => [
        'label' => 'lang:admin::lang.statuses.column_notify',
    ],
    'updated_at' => [
        'label' => 'lang:admin::lang.column_date_updated',
        'invisible' => true,
        'type' => 'datetime',
    ],
];

return $config;
