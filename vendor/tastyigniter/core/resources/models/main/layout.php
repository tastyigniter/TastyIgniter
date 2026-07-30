<?php

use Igniter\System\Rules\SafeMailTemplateContent;

return [
    'form' => [
        'fields' => [
            'settings[components]' => [
                'label' => 'lang:igniter::system.themes.text_tab_components',
                'type' => 'components',
                'prompt' => 'lang:igniter::system.themes.button_choose',
                'comment' => 'lang:igniter::system.themes.help_components',
                'form' => [
                    'fields' => [
                        'component' => [
                            'label' => 'lang:igniter::system.themes.label_component',
                            'type' => 'select',
                            'context' => 'create',
                        ],
                        'alias' => [
                            'label' => 'lang:igniter::system.themes.label_component_alias',
                            'type' => 'text',
                            'context' => ['edit', 'partial'],
                            'comment' => 'lang:igniter::system.themes.help_component_alias',
                            'attributes' => [
                                'data-toggle' => 'disabled',
                            ],
                        ],
                        'partial' => [
                            'label' => 'lang:igniter::system.themes.label_override_partial',
                            'type' => 'select',
                            'context' => 'partial',
                            'placeholder' => 'lang:igniter::admin.text_please_select',
                        ],
                    ],
                ],
            ],
        ],
        'tabs' => [
            'fields' => [
                'markup' => [
                    'tab' => 'lang:igniter::system.themes.text_tab_markup',
                    'type' => 'codeeditor',
                    'mode' => 'application/x-httpd-php',
                ],
                'codeSection' => [
                    'tab' => 'lang:igniter::system.themes.text_tab_php_section',
                    'type' => 'codeeditor',
                    'mode' => 'php',
                ],
                'settings[description]' => [
                    'tab' => 'lang:igniter::system.themes.text_tab_meta',
                    'label' => 'lang:igniter::admin.label_description',
                    'type' => 'text',
                ],
            ],
        ],
        'rules' => [
            'markup' => ['sometimes', new SafeMailTemplateContent],
            'codeSection' => ['sometimes', new SafeMailTemplateContent],
            'settings.components.*' => ['required', 'regex:/^[a-zA-Z\s\-\:\.]+$/'],
            'settings.description' => ['sometimes', 'max:255', new SafeMailTemplateContent],
        ],
        'validationAttributes' => [
            'markup' => lang('igniter::system.themes.text_tab_markup'),
            'codeSection' => lang('igniter::system.themes.text_tab_php_section'),
            'settings.components.*' => lang('igniter::system.themes.label_component_alias'),
            'settings.description' => lang('igniter::admin.label_description'),
        ],
    ],
];
