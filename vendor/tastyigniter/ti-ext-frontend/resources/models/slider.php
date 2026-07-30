<?php

return [
    'list' => [
        'filter' => [],
        'toolbar' => [
            'buttons' => [
                'create' => [
                    'label' => 'lang:admin::lang.button_new',
                    'class' => 'btn btn-primary',
                    'href' => 'igniter/frontend/sliders/create',
                ],
                'banners' => [
                    'label' => lang('igniter.frontend::default.banners.text_title'),
                    'class' => 'btn btn-default',
                    'href' => 'igniter/frontend/banners',
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
                    'href' => 'igniter/frontend/sliders/edit/{id}',
                ],
            ],
            'name' => [
                'label' => 'admin::lang.label_name',
            ],
            'code' => [
                'label' => 'igniter.frontend::default.slider.label_slider',
            ],
            'updated_at' => [
                'label' => 'igniter.frontend::default.slider.column_updated_at',
                'type' => 'timetense',
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
                    'label' => 'lang:admin::lang.button_icon_delete', 'class' => 'btn btn-danger',
                    'data-request' => 'onDelete', 'data-request-data' => "_method:'DELETE'",
                    'data-progress-indicator' => 'lang:admin::lang.text_deleting',
                    'data-request-confirm' => 'lang:admin::lang.alert_warning_confirm', 'context' => ['edit'],
                ],
            ],
        ],
        'fields' => [
            'name' => [
                'label' => 'admin::lang.label_name',
                'type' => 'text',
                'span' => 'left',
            ],
            'code' => [
                'label' => 'igniter.frontend::default.slider.label_slider',
                'type' => 'text',
                'span' => 'right',
            ],
            'images' => [
                'label' => 'igniter.frontend::default.slider.label_images',
                'type' => 'mediafinder',
                'useAttachment' => true,
                'isMulti' => true,
                'context' => ['edit'],
            ],
        ],
    ],
];
