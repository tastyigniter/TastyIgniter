<?php

return [
    'form' => [
        'fields' => [
            'settings[components]' => [
                'label' => 'lang:system::lang.themes.text_tab_components',
                'type' => 'components',
                'prompt' => 'lang:system::lang.themes.button_choose',
                'comment' => 'lang:system::lang.themes.help_components',
                'form' => [
                    'fields' => [
                        'component' => [
                            'label' => 'lang:system::lang.themes.label_component',
                            'type' => 'select',
                            'context' => 'create',
                        ],
                        'alias' => [
                            'label' => 'lang:system::lang.themes.label_component_alias',
                            'type' => 'text',
                            'context' => ['edit', 'partial'],
                            'comment' => 'lang:system::lang.themes.help_component_alias',
                            'attributes' => [
                                'data-toggle' => 'disabled',
                            ],
                        ],
                        'partial' => [
                            'label' => 'lang:system::lang.themes.label_override_partial',
                            'type' => 'select',
                            'context' => 'partial',
                            'placeholder' => 'lang:admin::lang.text_please_select',
                        ],
                    ],
                ],
            ],
        ],
        'tabs' => [
            'fields' => [
                'markup' => [
                    'tab' => 'lang:system::lang.themes.text_tab_markup',
                    'type' => 'codeeditor',
                    'mode' => 'application/x-httpd-php',
                ],
                'codeSection' => [
                    'tab' => 'lang:system::lang.themes.text_tab_php_section',
                    'type' => 'codeeditor',
                    'mode' => 'php',
                ],
                'settings[description]' => [
                    'tab' => 'lang:system::lang.themes.text_tab_meta',
                    'label' => 'lang:admin::lang.label_description',
                    'type' => 'textarea',
                ],
            ],
        ],
        'rules' => [
            'markup' => ['sometimes'],
            'codeSection' => ['sometimes'],
            'settings.components.*.alias' => ['sometimes', 'required', 'regex:/^[a-zA-Z\s]+$/'],
            'settings.description' => ['sometimes', 'max:255'],
        ],
        'validationAttributes' => [
            'markup' => lang('system::lang.themes.text_tab_markup'),
            'codeSection' => lang('system::lang.themes.text_tab_php_section'),
            'settings.components.*.alias' => lang('system::lang.themes.label_component_alias'),
            'settings.description' => lang('admin::lang.label_description'),
        ],
    ],
];
