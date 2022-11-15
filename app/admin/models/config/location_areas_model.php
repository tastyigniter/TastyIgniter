<?php

return [
    'form' => [
        'fields' => [
            'name' => [
                'label' => 'lang:admin::lang.locations.label_area_name',
                'type' => 'text',
                'span' => 'left',
                'attributes' => [
                    'data-map-shape-name' => '',
                ],
            ],
            'is_default' => [
                'label' => 'lang:admin::lang.locations.label_area_default',
                'type' => 'radiotoggle',
                'span' => 'right',
                'options' => [
                    'lang:admin::lang.text_no',
                    'lang:admin::lang.text_yes',
                ],
                'attributes' => [
                    'data-toggle' => 'area-default',
                ],
            ],
            'type' => [
                'label' => 'lang:admin::lang.locations.label_area_type',
                'type' => 'radiotoggle',
                'default' => 'address',
                'options' => [
                    'address' => 'lang:admin::lang.locations.text_custom',
                    'polygon' => 'lang:admin::lang.locations.text_shape',
                    'circle' => 'lang:admin::lang.locations.text_circle',
                ],
                'attributes' => [
                    'data-toggle' => 'map-shape',
                ],
            ],
            'boundaries[components]' => [
                'label' => 'lang:admin::lang.locations.label_address_component',
                'type' => 'repeater',
                'sortable' => true,
                'commentAbove' => 'lang:admin::lang.locations.help_delivery_components',
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
                            'label' => 'lang:admin::lang.locations.label_address_component_type',
                            'type' => 'select',
                            'default' => 'region',
                            'options' => [
                                'street' => 'lang:admin::lang.locations.text_address_component_street',
                                'sub_locality' => 'lang:admin::lang.locations.text_address_component_town',
                                'locality' => 'lang:admin::lang.locations.text_address_component_city',
                                'admin_level_2' => 'lang:admin::lang.locations.text_address_component_region',
                                'admin_level_1' => 'lang:admin::lang.locations.text_address_component_state',
                                'postal_code' => 'lang:admin::lang.locations.text_address_component_postal_code',
                            ],
                        ],
                        'value' => [
                            'label' => 'lang:admin::lang.locations.label_address_component_value',
                            'type' => 'text',
                        ],
                    ],
                ],
            ],
            'conditions' => [
                'label' => 'lang:admin::lang.locations.label_delivery_condition',
                'type' => 'repeater',
                'sortable' => true,
                'commentAbove' => 'lang:admin::lang.locations.help_delivery_condition',
                'form' => [
                    'fields' => [
                        'priority' => [
                            'type' => 'hidden',
                        ],
                        'amount' => [
                            'label' => 'lang:admin::lang.locations.label_area_charge',
                            'type' => 'currency',
                            'default' => 0,
                        ],
                        'type' => [
                            'label' => 'lang:admin::lang.locations.label_charge_condition',
                            'type' => 'radiotoggle',
                            'default' => 'above',
                            'options' => [
                                'all' => 'lang:admin::lang.locations.text_all_orders',
                                'below' => 'lang:admin::lang.locations.text_below_order_total',
                                'above' => 'lang:admin::lang.locations.text_above_order_total',
                            ],
                        ],
                        'total' => [
                            'label' => 'lang:admin::lang.locations.label_area_min_amount',
                            'type' => 'currency',
                            'default' => 0,
                        ],
                    ],
                ],
            ],
            'boundaries[distance]' => [
                'label' => 'lang:admin::lang.locations.label_delivery_distance',
                'type' => 'repeater',
                'sortable' => true,
                'commentAbove' => 'lang:admin::lang.locations.help_delivery_distance',
                'form' => [
                    'fields' => [
                        'priority' => [
                            'type' => 'hidden',
                        ],
                        'type' => [
                            'label' => 'lang:admin::lang.locations.label_charge_condition',
                            'type' => 'select',
                            'options' => [
                                'greater' => 'greater than',
                                'less' => 'less than',
                                'equals_or_greater' => 'equals or greater than',
                                'equals_or_less' => 'equals or less than',
                            ],
                        ],
                        'distance' => [
                            'label' => 'lang:admin::lang.locations.label_area_distance',
                            'type' => 'text',
                        ],
                        'charge' => [
                            'label' => 'lang:admin::lang.locations.label_area_charge',
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
