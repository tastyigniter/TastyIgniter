<?php

return [
    'form' => [
        'tabs' => [
            'fields' => [
                'markup' => [
                    'tab' => 'lang:system::lang.themes.text_tab_markup',
                    'type' => 'codeeditor',
                    'mode' => 'html',
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
            'settings.description' => ['max:255'],
        ],
        'validationAttributes' => [
            'markup' => lang('system::lang.themes.text_tab_markup'),
            'settings.description' => lang('admin::lang.label_description'),
        ],
    ],
];
