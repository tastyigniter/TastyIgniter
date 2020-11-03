<?php

return [
    'form' => [
        'tabs' => [
            'fields' => [
                'markup' => [
                    'tab' => 'lang:system::lang.themes.text_tab_markup',
                    'type' => 'codeeditor',
                    'mode' => 'application/x-httpd-php',
                ],
                'settings[description]' => [
                    'tab' => 'lang:system::lang.themes.text_tab_meta',
                    'label' => 'lang:admin::lang.label_description',
                    'type' => 'textarea',
                ],
            ],
        ],
        'rules' => [
            ['markup', 'lang:system::lang.themes.text_tab_markup', 'sometimes'],
            ['settings.description', 'lang:admin::lang.label_description', 'sometimes|max:255'],
        ],
    ],
];
