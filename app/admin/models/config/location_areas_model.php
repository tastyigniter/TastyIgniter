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
                    'polygon' => 'lang:admin::lang.locations.text_shape',
                    'circle'  => 'lang:admin::lang.locations.text_circle',
                ],
                'attributes' => [
                    'data-toggle' => 'map-shape',
                ],
            ],
            'is_default'           => [
                'type' => 'switch',
                'on'   => 'lang:admin::lang.text_default',
                'off'  => 'lang:admin::lang.text_default',
            ],
            'conditions'           => [
                'label'        => 'lang:admin::lang.locations.label_delivery_condition',
                'type'         => 'repeater',
                'sortable'     => TRUE,
                'commentAbove' => 'lang:admin::lang.locations.help_delivery_condition',
                'form'         => [
                    'fields' => [
                        'priority' => [
                            'type' => 'hidden',
                        ],
                        'amount'   => [
                            'label'   => 'lang:admin::lang.locations.label_area_charge',
                            'type'    => 'number',
                            'default' => 0,
                        ],
                        'type'     => [
                            'label'   => 'lang:admin::lang.locations.label_charge_condition',
                            'type'    => 'radio',
                            'default' => 'above',
                            'options' => [
                                'all'   => 'lang:admin::lang.locations.text_all_orders',
                                'below' => 'lang:admin::lang.locations.text_below_order_total',
                                'above' => 'lang:admin::lang.locations.text_above_order_total',
                            ],
                        ],
                        'total'    => [
                            'label'   => 'lang:admin::lang.locations.label_area_min_amount',
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