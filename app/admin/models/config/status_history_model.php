<?php
$config['list']['columns'] = [
    'date_added' => [
        'label' => 'lang:admin::statuses.column_time_date',
        'type' => 'datetime',
    ],
    'staff_name' => [
        'label' => 'lang:admin::statuses.column_staff',
        'relation' => 'staff',
        'select'     => 'staff_name',
    ],
    'assignee_name' => [
        'label' => 'lang:admin::statuses.column_assignee',
        'relation' => 'assignee',
        'select'     => 'staff_name',
    ],
    'status' => [
        'label' => 'lang:admin::statuses.column_status',
        'relation'   => 'status',
        'select'     => 'status_name',
    ],
    'comment' => [
        'label' => 'lang:admin::statuses.column_comment'
    ],
    'notified' => [
        'label' => 'lang:admin::statuses.column_notify',
    ],
];

return $config;