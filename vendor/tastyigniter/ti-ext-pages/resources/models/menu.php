<?php

declare(strict_types=1);

use Igniter\Pages\Http\Requests\MenuItemRequest;

return [
    'list' => [
        'toolbar' => [
            'buttons' => [
                'back' => [
                    'label' => 'admin::lang.button_icon_back',
                    'class' => 'btn btn-outline-secondary',
                    'href' => 'igniter/pages/pages',
                ],
                'create' => [
                    'label' => 'lang:admin::lang.button_new',
                    'class' => 'btn btn-primary',
                    'href' => 'igniter/pages/menus/create',
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
                    'href' => 'igniter/pages/menus/edit/{id}',
                ],
            ],
            'name' => [
                'label' => 'admin::lang.label_name',
            ],
            'code' => [
                'label' => 'igniter.pages::default.menu.label_code',
            ],
            'theme_name' => [
                'label' => 'igniter.pages::default.menu.label_theme',
                'disabled' => true,
                'sortable' => false,
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
            'theme_code@create' => [
                'label' => 'igniter.pages::default.menu.label_theme',
                'type' => 'select',
                'span' => 'left',
                'cssClass' => 'flex-width',
            ],
            'theme_code@edit' => [
                'label' => 'igniter.pages::default.menu.label_theme',
                'type' => 'select',
                'span' => 'left',
                'cssClass' => 'flex-width',
                'disabled' => true,
            ],
            'name' => [
                'label' => 'admin::lang.label_name',
                'type' => 'text',
                'span' => 'left',
                'cssClass' => 'flex-width',
            ],
            'code' => [
                'label' => 'igniter.pages::default.menu.label_code',
                'type' => 'text',
                'span' => 'right',
            ],
        ],
        'tabs' => [
            'fields' => [
                'items' => [
                    'tab' => 'igniter.pages::default.menu.text_menu_items',
                    'type' => 'connector',
                    'context' => 'edit',
                    'form' => 'menuitem',
                    'nameFrom' => 'title',
                    'sortable' => true,
                    'partial' => 'form/type_info_summary',
                    'containerAttributes' => [
                        'data-control' => 'menu-item-editor',
                    ],
                    'request' => MenuItemRequest::class,
                ],
                '_new_item' => [
                    'tab' => 'igniter.pages::default.menu.text_menu_items',
                    'type' => 'partial',
                    'path' => 'form/new_item_btn',
                    'context' => 'edit',
                ],
            ],
        ],
    ],
];
