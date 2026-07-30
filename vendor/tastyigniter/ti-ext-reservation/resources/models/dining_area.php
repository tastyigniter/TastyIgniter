<?php

use Igniter\Reservation\Models\DiningSection;

return [
    'list' => [
        'filter' => [],
        'toolbar' => [
            'buttons' => [
                'create' => [
                    'label' => 'lang:admin::lang.button_new',
                    'class' => 'btn btn-primary',
                    'href' => 'dining_areas/create',
                ],
            ],
        ],
        'bulkActions' => [
            'delete' => [
                'label' => 'lang:admin::lang.button_delete',
                'class' => 'btn btn-light text-danger',
                'data-request-confirm' => 'lang:admin::lang.alert_warning_confirm',
            ],
        ],
        'columns' => [
            'edit' => [
                'type' => 'button',
                'iconCssClass' => 'fa fa-pencil',
                'attributes' => [
                    'class' => 'btn btn-edit',
                    'href' => 'dining_areas/edit/{id}',
                ],
            ],
            'duplicate' => [
                'type' => 'button',
                'iconCssClass' => 'fa fa-copy  text-muted',
                'attributes' => [
                    'class' => 'btn shadow-none',
                    'data-request' => 'onDuplicate',
                    'data-request-data' => 'id: {id}',
                ],
            ],
            'name' => [
                'label' => 'lang:admin::lang.label_name',
                'type' => 'text',
                'searchable' => true,
            ],
            'location_name' => [
                'label' => 'lang:admin::lang.column_location',
                'relation' => 'location',
                'select' => 'location_name',
                'searchable' => true,
                'locationAware' => true,
            ],
            'dining_table_count' => [
                'label' => 'lang:igniter.reservation::default.dining_areas.column_tables',
                'type' => 'number',
                'sortable' => false,
            ],
            'updated_at' => [
                'label' => 'lang:admin::lang.column_date_updated',
                'type' => 'timetense',
                'invisible' => true,
            ],
            'created_at' => [
                'label' => 'lang:admin::lang.column_date_added',
                'type' => 'timetense',
                'invisible' => true,
            ],
        ],
    ],
    'form' => [
        'toolbar' => [
            'buttons' => [
                'save' => [
                    'label' => 'lang:admin::lang.button_save',
                    'context' => ['create', 'edit'],
                    'partial' => 'form/toolbar_save_button',
                    'class' => 'btn btn-primary',
                    'data-request' => 'onSave',
                    'data-progress-indicator' => 'admin::lang.text_saving',
                ],
                'delete' => [
                    'label' => 'lang:admin::lang.button_icon_delete',
                    'class' => 'btn btn-danger',
                    'data-request' => 'onDelete',
                    'data-request-data' => "_method:'DELETE'",
                    'data-request-confirm' => 'lang:admin::lang.alert_warning_confirm',
                    'data-progress-indicator' => 'admin::lang.text_deleting',
                    'context' => ['edit'],
                ],
            ],
        ],
        'fields' => [
            'name' => [
                'label' => 'lang:admin::lang.label_name',
                'type' => 'text',
                'span' => 'left',
            ],
            'location_id' => [
                'label' => 'lang:admin::lang.label_location',
                'type' => 'relation',
                'span' => 'right',
                'relationFrom' => 'location',
                'nameFrom' => 'location_name',
                'placeholder' => 'lang:admin::lang.text_please_select',
            ],
        ],
        'tabs' => [
            'fields' => [
                '_dining_sections' => [
                    'label' => 'igniter.reservation::default.dining_areas.label_dining_sections',
                    'tab' => 'igniter.reservation::default.dining_areas.text_tab_tables',
                    'type' => 'recordeditor',
                    'context' => ['edit', 'preview'],
                    'mode' => 'checkbox',
                    'form' => 'dining_section',
                    'modelClass' => DiningSection::class,
                    'placeholder' => 'igniter.reservation::default.dining_areas.help_dining_sections',
                    'formName' => 'igniter.reservation::default.dining_areas.text_dining_section',
                ],
                'dining_table_solos' => [
                    'label' => 'igniter.reservation::default.dining_areas.label_tables',
                    'tab' => 'igniter.reservation::default.dining_areas.text_tab_tables',
                    'type' => 'connector',
                    'context' => 'edit',
                    'form' => 'dining_table',
                    'partial' => 'form/dining_table_info',
                    'hideNewButton' => false,
                    'commentAbove' => 'igniter.reservation::default.dining_tables.help_extra_capacity',
                ],

                '_select_dining_tables' => [
                    'label' => 'igniter.reservation::default.dining_areas.label_dining_table_combos',
                    'tab' => 'igniter.reservation::default.dining_areas.text_tab_table_combos',
                    'type' => 'partial',
                    'path' => 'form/select_dining_tables',
                    'context' => ['edit', 'preview'],
                    'valueFrom' => 'dining_tables',
                ],
                'dining_table_combos' => [
                    'label' => 'igniter.reservation::default.dining_areas.label_table_combos',
                    'tab' => 'igniter.reservation::default.dining_areas.text_tab_table_combos',
                    'type' => 'connector',
                    'context' => 'edit',
                    'form' => 'dining_table_combo',
                    'partial' => 'form/dining_table_info',
                ],

                'floor_plan' => [
                    'tab' => 'igniter.reservation::default.dining_areas.text_tab_table_layout',
                    'type' => 'floorplanner',
                    'context' => 'edit',
                    'options' => 'getTablesForFloorPlan',
                    'connectorField' => 'dining_table_solos',
                ],
            ],
        ],
    ],
];
