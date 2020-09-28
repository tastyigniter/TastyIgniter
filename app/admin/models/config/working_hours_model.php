<?php

return [
    'form' => [
        'fields' => [
            'name' => [
                'label' => 'lang:admin::lang.locations.label_schedule_name',
                'type' => 'text',
            ],
            'type' => [
                'label' => 'lang:admin::lang.locations.label_schedule_type',
                'type' => 'radiotoggle',
                'default' => 'daily',
                'options' => [
                    '24_7' => 'lang:admin::lang.locations.text_24_7',
                    'daily' => 'lang:admin::lang.locations.text_daily',
                    'flexible' => 'lang:admin::lang.locations.text_flexible',
                ],
            ],
            'days' => [
                'label' => 'lang:admin::lang.locations.label_schedule_days',
                'type' => 'checkboxtoggle',
                'options' => 'getWeekDaysOptions',
                'default' => [0, 1, 2, 3, 4, 5, 6],
                'trigger' => [
                    'action' => 'show',
                    'field' => 'type',
                    'condition' => 'value[daily]',
                ],
            ],
            'start_time' => [
                'label' => 'lang:admin::lang.locations.label_schedule_open',
                'type' => 'datepicker',
                'default' => '12:00 AM',
                'mode' => 'time',
                'span' => 'left',
                'trigger' => [
                    'action' => 'show',
                    'field' => 'type',
                    'condition' => 'value[daily]',
                ],
            ],
            'end_time' => [
                'label' => 'lang:admin::lang.locations.label_schedule_close',
                'type' => 'datepicker',
                'default' => '11:59 PM',
                'mode' => 'time',
                'span' => 'right',
                'trigger' => [
                    'action' => 'show',
                    'field' => 'type',
                    'condition' => 'value[daily]',
                ],
            ],
            'flexible' => [
                'label' => 'lang:admin::lang.locations.text_flexible',
                'type' => 'partial',
                'path' => 'locations/flexible_hours',
                'trigger' => [
                    'action' => 'show',
                    'field' => 'type',
                    'condition' => 'value[flexible]',
                ],
            ],
        ],
    ],
];
