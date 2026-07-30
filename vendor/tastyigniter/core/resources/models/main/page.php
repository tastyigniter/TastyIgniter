<?php

use Igniter\System\Rules\SafeMailTemplateContent;

return [
    'form' => [
        'fields' => [
            'settings[components]' => [
                'type' => 'components',
                'label' => 'igniter::system.themes.button_choose',
                'comment' => 'igniter::system.themes.help_components',
                'form' => [
                    'fields' => [
                        'alias' => [
                            'label' => 'igniter::system.themes.label_component_alias',
                            'type' => 'text',
                            'context' => ['edit', 'partial'],
                            'comment' => 'igniter::system.themes.help_component_alias',
                            'attributes' => [
                                'data-toggle' => 'disabled',
                            ],
                        ],
                        'partial' => [
                            'label' => 'igniter::system.themes.label_override_partial',
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
                    'tab' => 'igniter::system.themes.text_tab_markup',
                    'type' => 'codeeditor',
                    'mode' => 'application/x-httpd-php',
                ],
                'codeSection' => [
                    'tab' => 'igniter::system.themes.text_tab_php_section',
                    'type' => 'codeeditor',
                    'mode' => 'php',
                ],
                'settings[title]' => [
                    'label' => 'igniter::system.themes.label_title',
                    'tab' => 'igniter::system.themes.text_tab_meta',
                    'type' => 'text',
                    'span' => 'left',
                ],
                'settings[permalink]' => [
                    'tab' => 'igniter::system.themes.text_tab_meta',
                    'label' => 'igniter::system.themes.label_permalink',
                    'type' => 'text',
                    'span' => 'right',
                ],
                'settings[layout]' => [
                    'tab' => 'igniter::system.themes.text_tab_meta',
                    'label' => 'igniter::system.themes.label_layout',
                    'type' => 'select',
                    'options' => 'getLayoutOptions',
                    'placeholder' => 'lang:igniter::admin.text_please_select',
                ],
                'settings[description]' => [
                    'tab' => 'igniter::system.themes.text_tab_meta',
                    'label' => 'lang:igniter::admin.label_description',
                    'type' => 'text',
                ],
                'settings[isHidden]' => [
                    'tab' => 'igniter::system.themes.text_tab_meta',
                    'label' => 'igniter::system.themes.label_hidden',
                    'type' => 'switch',
                    'span' => 'left',
                ],
            ],
        ],
        'rules' => [
            'markup' => ['string', new SafeMailTemplateContent],
            'codeSection' => ['nullable', 'string', new SafeMailTemplateContent],
            'settings.components.*' => ['required', 'regex:/^[a-zA-Z\s\-\:\.]+$/'],
            'settings.title' => ['required', 'max:160', new SafeMailTemplateContent],
            'settings.description' => ['max:255', new SafeMailTemplateContent],
            'settings.layout' => ['string', new SafeMailTemplateContent],
            'settings.permalink' => ['required', 'string', new SafeMailTemplateContent],
        ],
        'validationAttributes' => [
            'markup' => lang('igniter::system.themes.text_tab_markup'),
            'codeSection' => lang('igniter::system.themes.text_tab_php_section'),
            'settings.components.*' => lang('igniter::system.themes.label_component_alias'),
            'settings.title' => lang('igniter::system.themes.label_title'),
            'settings.description' => lang('igniter::admin.label_description'),
            'settings.layout' => lang('igniter::system.themes.label_layout'),
            'settings.permalink' => lang('igniter::system.themes.label_permalink'),
        ],
    ],
];
