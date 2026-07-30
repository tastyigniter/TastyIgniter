<?php

return [
    'form' => [
        'fields' => [
            'type' => [
                'label' => 'lang:igniter.local::default.label_schedule_type',
                'type' => 'radiotoggle',
                'default' => 'daily',
                'options' => [
                    '24_7' => 'lang:igniter.local::default.text_24_7',
                    'daily' => 'lang:igniter.local::default.text_daily',
                    'timesheet' => 'lang:igniter.local::default.text_timesheet',
                    'flexible' => 'lang:igniter.local::default.text_flexible',
                ],
            ],
            'days' => [
                'label' => 'lang:igniter.local::default.label_schedule_days',
                'type' => 'checkboxtoggle',
                'options' => 'getWeekDaysOptions',
                'default' => [0, 1, 2, 3, 4, 5, 6],
                'trigger' => [
                    'action' => 'show',
                    'field' => 'type',
                    'condition' => 'value[daily]',
                ],
            ],
            'open' => [
                'label' => 'lang:igniter.local::default.label_schedule_open',
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
            'close' => [
                'label' => 'lang:igniter.local::default.label_schedule_close',
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
            'timesheet' => [
                'label' => 'lang:igniter.local::default.text_timesheet',
                'type' => 'partial',
                'path' => 'locations/timesheet',
                'trigger' => [
                    'action' => 'show',
                    'field' => 'type',
                    'condition' => 'value[timesheet]',
                ],
            ],
            'flexible' => [
                'label' => 'lang:igniter.local::default.text_flexible',
                'type' => 'partial',
                'path' => 'locations/flexible_hours',
                'commentAbove' => 'lang:igniter.local::default.help_flexible_hours',
                'trigger' => [
                    'action' => 'show',
                    'field' => 'type',
                    'condition' => 'value[flexible]',
                ],
            ],
        ],
    ],
];
