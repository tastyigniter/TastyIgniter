<?php

return [
    'form' => [
        'fields' => [
            'name' => [
                'label' => 'lang:igniter.local::default.label_area_name',
                'type' => 'text',
                'span' => 'left',
                'attributes' => [
                    'data-map-shape-name' => '',
                ],
            ],
            'is_default' => [
                'label' => 'lang:igniter.local::default.label_area_default',
                'type' => 'radiotoggle',
                'span' => 'right',
                'options' => [
                    'lang:igniter::admin.text_no',
                    'lang:igniter::admin.text_yes',
                ],
                'attributes' => [
                    'data-toggle' => 'area-default',
                ],
            ],
            'conditions' => [
                'label' => 'lang:igniter.local::default.label_delivery_condition',
                'type' => 'repeater',
                'sortable' => true,
                'commentAbove' => 'lang:igniter.local::default.help_delivery_condition',
                'form' => [
                    'fields' => [
                        'priority' => [
                            'type' => 'hidden',
                        ],
                        'amount' => [
                            'label' => 'lang:igniter.local::default.label_area_charge',
                            'type' => 'currency',
                            'default' => 0,
                        ],
                        'type' => [
                            'label' => 'lang:igniter.local::default.label_charge_condition',
                            'type' => 'radiotoggle',
                            'default' => 'above',
                            'options' => [
                                'all' => 'lang:igniter.local::default.text_all_orders',
                                'below' => 'lang:igniter.local::default.text_below_order_total',
                                'above' => 'lang:igniter.local::default.text_above_order_total',
                            ],
                        ],
                        'total' => [
                            'label' => 'lang:igniter.local::default.label_area_min_amount',
                            'type' => 'currency',
                            'default' => 0,
                        ],
                    ],
                ],
            ],
            'boundaries[distance]' => [
                'label' => 'lang:igniter.local::default.label_delivery_distance',
                'type' => 'repeater',
                'sortable' => true,
                'commentAbove' => 'lang:igniter.local::default.help_delivery_distance',
                'form' => [
                    'fields' => [
                        'priority' => [
                            'type' => 'hidden',
                        ],
                        'type' => [
                            'label' => 'lang:igniter.local::default.label_charge_condition',
                            'type' => 'select',
                            'options' => [
                                'greater' => 'greater than',
                                'less' => 'less than',
                                'equals_or_greater' => 'equals or greater than',
                                'equals_or_less' => 'equals or less than',
                            ],
                        ],
                        'distance' => [
                            'label' => 'lang:igniter.local::default.label_area_distance',
                            'type' => 'text',
                        ],
                        'charge' => [
                            'label' => 'lang:igniter.local::default.label_area_charge',
                            'type' => 'text',
                        ],
                    ],
                ],
            ],
            'type' => [
                'label' => 'lang:igniter.local::default.label_area_type',
                'type' => 'radiotoggle',
                'default' => 'address',
                'options' => [
                    'address' => 'lang:igniter.local::default.text_custom',
                    'polygon' => 'lang:igniter.local::default.text_shape',
                    'circle' => 'lang:igniter.local::default.text_circle',
                ],
                'attributes' => [
                    'data-toggle' => 'map-shape',
                ],
            ],
            'boundaries[components]' => [
                'type' => 'repeater',
                'sortable' => true,
                'commentAbove' => 'lang:igniter.local::default.help_delivery_components',
                'trigger' => [
                    'action' => 'show',
                    'field' => 'type',
                    'condition' => 'value[address]',
                ],
                'form' => [
                    'fields' => [
                        'priority' => [
                            'type' => 'hidden',
                        ],
                        'type' => [
                            'label' => 'lang:igniter.local::default.label_address_component_type',
                            'type' => 'select',
                            'default' => 'region',
                            'options' => [
                                'street' => 'lang:igniter.local::default.text_address_component_street',
                                'sub_locality' => 'lang:igniter.local::default.text_address_component_town',
                                'locality' => 'lang:igniter.local::default.text_address_component_city',
                                'admin_level_2' => 'lang:igniter.local::default.text_address_component_region',
                                'admin_level_1' => 'lang:igniter.local::default.text_address_component_state',
                                'postal_code' => 'lang:igniter.local::default.text_address_component_postal_code',
                            ],
                        ],
                        'value' => [
                            'label' => 'lang:igniter.local::default.label_address_component_value',
                            'type' => 'text',
                        ],
                    ],
                ],
            ],
            '_mapview' => [
                'type' => 'mapview',
                'zoom' => 14,
                'height' => 640,
                'shapeSelector' => '[data-map-shape]',
                'trigger' => [
                    'action' => 'hide',
                    'field' => 'type',
                    'condition' => 'value[address]',
                ],
            ],
            'location_id' => [
                'type' => 'hidden',
            ],
            'color' => [
                'type' => 'hidden',
                'attributes' => [
                    'data-shape-value' => 'color',
                ],
            ],
            'boundaries[polygon]' => [
                'type' => 'hidden',
                'attributes' => [
                    'data-shape-value' => 'polygon',
                ],
            ],
            'boundaries[vertices]' => [
                'type' => 'hidden',
                'attributes' => [
                    'data-shape-value' => 'vertices',
                ],
            ],
            'boundaries[circle]' => [
                'type' => 'hidden',
                'attributes' => [
                    'data-shape-value' => 'circle',
                ],
            ],
        ],
    ],
];
