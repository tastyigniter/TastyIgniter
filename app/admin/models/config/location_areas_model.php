<?php

return [
    'form' => [
        'fields' => [
            'name'                 => [
                'type' => 'text',
            ],
            'type'                 => [
                'type'       => 'radio',
                'default'    => 'polygon',
                'options'    => [
                    'polygon' => 'lang:admin::locations.text_shape',
                    'circle'  => 'lang:admin::locations.text_circle',
                ],
                'attributes' => [
                    'data-toggle' => 'map-shape',
                ],
            ],
            'is_default'           => [
                'type' => 'switch',
                'on'   => 'lang:admin::default.text_default',
                'off'  => 'lang:admin::default.text_default',
            ],
            'conditions'           => [
                'label'        => 'lang:admin::locations.label_delivery_condition',
                'type'         => 'repeater',
                'sortable'     => TRUE,
                'commentAbove' => 'lang:admin::locations.help_delivery_condition',
                'form'         => [
                    'fields' => [
                        'priority' => [
                            'type' => 'hidden',
                        ],
                        'amount'   => [
                            'label'   => 'lang:admin::locations.label_area_charge',
                            'type'    => 'number',
                            'default' => 0,
                        ],
                        'type'     => [
                            'label'   => 'lang:admin::locations.label_charge_condition',
                            'type'    => 'radio',
                            'default' => 'above',
                            'options' => [
                                'all'   => 'lang:admin::locations.text_all_orders',
                                'below' => 'lang:admin::locations.text_below_order_total',
                                'above' => 'lang:admin::locations.text_above_order_total',
                            ],
                        ],
                        'total'    => [
                            'label'   => 'lang:admin::locations.label_area_min_amount',
                            'type'    => 'number',
                            'default' => 0,
                        ],
                    ],
                ],
            ],
            'area_id'              => [
                'type'       => 'hidden',
                'attributes' => [
                    'data-shape-value' => 'area_id',
                ],
            ],
            'boundaries[polygon]'  => [
                'type'       => 'hidden',
                'attributes' => [
                    'data-shape-value' => 'polygon',
                ],
            ],
            'boundaries[vertices]' => [
                'type'       => 'hidden',
                'attributes' => [
                    'data-shape-value' => 'vertices',
                ],
            ],
            'boundaries[circle]'   => [
                'type'       => 'hidden',
                'attributes' => [
                    'data-shape-value' => 'circle',
                ],
            ],
        ],
    ],
];