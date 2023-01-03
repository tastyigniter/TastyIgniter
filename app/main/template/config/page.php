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
                'settings[title]' => [
                    'label' => 'lang:system::lang.themes.label_title',
                    'tab' => 'lang:system::lang.themes.text_tab_meta',
                    'type' => 'text',
                    'span' => 'left',
                ],
                'settings[permalink]' => [
                    'tab' => 'lang:system::lang.themes.text_tab_meta',
                    'label' => 'lang:system::lang.themes.label_permalink',
                    'type' => 'text',
                    'span' => 'right',
                ],
                'settings[layout]' => [
                    'tab' => 'lang:system::lang.themes.text_tab_meta',
                    'label' => 'lang:system::lang.themes.label_layout',
                    'type' => 'select',
                    'options' => 'getLayoutOptions',
                ],
                'settings[description]' => [
                    'tab' => 'lang:system::lang.themes.text_tab_meta',
                    'label' => 'lang:admin::lang.label_description',
                    'type' => 'textarea',
                ],
            ],
        ],
        'rules' => [
            'markup' => ['string'],
            'codeSection' => ['nullable', 'string'],
            'settings.components.*' => ['required', 'regex:/^[a-zA-Z\s]+$/'],
            'settings.title' => ['required', 'max:160'],
            'settings.description' => ['max:255'],
            'settings.layout' => ['string'],
            'settings.permalink' => ['required', 'string'],
        ],
        'validationAttributes' => [
            'markup' => lang('system::lang.themes.text_tab_markup'),
            'codeSection' => lang('system::lang.themes.text_tab_php_section'),
            'settings.components.*' => lang('system::lang.themes.label_component_alias'),
            'settings.title' => lang('system::lang.themes.label_title'),
            'settings.description' => lang('admin::lang.label_description'),
            'settings.layout' => lang('system::lang.themes.label_layout'),
            'settings.permalink' => lang('system::lang.themes.label_permalink'),
        ],
    ],
];
