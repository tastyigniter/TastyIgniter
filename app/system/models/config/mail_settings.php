<?php

return [
    'form' => [
        'toolbar' => [
            'buttons' => [
                'back' => [
                    'label' => 'lang:admin::lang.button_icon_back',
                    'class' => 'btn btn-default',
                    'href' => 'settings',
                ],
                'save' => [
                    'label' => 'lang:admin::lang.button_save',
                    'class' => 'btn btn-primary',
                    'data-request-submit' => 'true',
                    'data-request' => 'onSave',
                ],
                'saveClose' => [
                    'label' => 'lang:admin::lang.button_save_close',
                    'class' => 'btn btn-default',
                    'data-request' => 'onSave',
                    'data-request-submit' => 'true',
                    'data-request-data' => 'close:1',
                ],
            ],
        ],
        'fields' => [
            'sender_name' => [
                'label' => 'lang:system::lang.settings.label_sender_name',
                'type' => 'text',
                'span' => 'left',
            ],
            'sender_email' => [
                'label' => 'lang:system::lang.settings.label_sender_email',
                'type' => 'text',
                'span' => 'right',
            ],
            'protocol' => [
                'label' => 'lang:system::lang.settings.label_protocol',
                'type' => 'select',
                'default' => 'sendmail',
                'options' => [
                    'log' => 'lang:system::lang.settings.text_log_file',
                    'sendmail' => 'lang:system::lang.settings.text_sendmail',
                    'smtp' => 'lang:system::lang.settings.text_smtp',
                    'mailgun' => 'lang:system::lang.settings.text_mailgun',
                    'ses' => 'lang:system::lang.settings.text_ses',
                ],
            ],

            'sendmail_path' => [
                'label' => 'lang:system::lang.settings.label_sendmail_path',
                'comment' => 'lang:system::lang.settings.help_sendmail_path',
                'type' => 'text',
                'default' => '/usr/sbin/sendmail -bs',
                'trigger' => [
                    'action' => 'show',
                    'field' => 'protocol',
                    'condition' => 'value[sendmail]',
                ],
            ],

            'smtp_host' => [
                'label' => 'lang:system::lang.settings.label_smtp_host',
                'type' => 'text',
                'trigger' => [
                    'action' => 'show',
                    'field' => 'protocol',
                    'condition' => 'value[smtp]',
                ],
            ],
            'smtp_port' => [
                'label' => 'lang:system::lang.settings.label_smtp_port',
                'type' => 'text',
                'span' => 'left',
                'trigger' => [
                    'action' => 'show',
                    'field' => 'protocol',
                    'condition' => 'value[smtp]',
                ],
            ],
            'smtp_encryption' => [
                'label' => 'lang:system::lang.settings.label_smtp_encryption',
                'type' => 'select',
                'default' => 'tls',
                'span' => 'right',
                'options' => [
                    '' => 'lang:system::lang.settings.text_mail_no_encryption',
                    'tls' => 'lang:system::lang.settings.text_mail_tls_encryption',
                    'ssl' => 'lang:system::lang.settings.text_mail_ssl_encryption',
                ],
                'trigger' => [
                    'action' => 'show',
                    'field' => 'protocol',
                    'condition' => 'value[smtp]',
                ],
            ],
            'smtp_user' => [
                'label' => 'lang:system::lang.settings.label_smtp_user',
                'type' => 'text',
                'span' => 'left',
                'trigger' => [
                    'action' => 'show',
                    'field' => 'protocol',
                    'condition' => 'value[smtp]',
                ],
            ],
            'smtp_pass' => [
                'label' => 'lang:system::lang.settings.label_smtp_pass',
                'type' => 'text',
                'span' => 'right',
                'trigger' => [
                    'action' => 'show',
                    'field' => 'protocol',
                    'condition' => 'value[smtp]',
                ],
            ],

            'mailgun_domain' => [
                'label' => 'lang:system::lang.settings.label_mailgun_domain',
                'type' => 'text',
                'span' => 'left',
                'trigger' => [
                    'action' => 'show',
                    'field' => 'protocol',
                    'condition' => 'value[mailgun]',
                ],
            ],
            'mailgun_secret' => [
                'label' => 'lang:system::lang.settings.label_mailgun_secret',
                'type' => 'text',
                'span' => 'right',
                'trigger' => [
                    'action' => 'show',
                    'field' => 'protocol',
                    'condition' => 'value[mailgun]',
                ],
            ],

            'ses_key' => [
                'label' => 'lang:system::lang.settings.label_ses_key',
                'type' => 'text',
                'trigger' => [
                    'action' => 'show',
                    'field' => 'protocol',
                    'condition' => 'value[ses]',
                ],
            ],
            'ses_secret' => [
                'label' => 'lang:system::lang.settings.label_ses_secret',
                'type' => 'text',
                'trigger' => [
                    'action' => 'show',
                    'field' => 'protocol',
                    'condition' => 'value[ses]',
                ],
            ],
            'ses_region' => [
                'label' => 'lang:system::lang.settings.label_ses_region',
                'type' => 'text',
                'trigger' => [
                    'action' => 'show',
                    'field' => 'protocol',
                    'condition' => 'value[ses]',
                ],
            ],
            'test_email' => [
                'label' => 'lang:system::lang.settings.label_test_email',
                'type' => 'partial',
                'path' => 'settings/test_email_button',
                'span' => 'left',
            ],
        ],
        'rules' => [
            ['sender_name', 'lang:system::lang.settings.label_sender_name', 'required'],
            ['sender_email', 'lang:system::lang.settings.label_sender_email', 'required'],
            ['protocol', 'lang:system::lang.settings.label_protocol', 'required'],

            ['sendmail_path', 'lang:system::lang.settings.label_sendmail_path', 'required_if:protocol,sendmail|string'],

            ['smtp_host', 'lang:system::lang.settings.label_smtp_host', 'string'],
            ['smtp_port', 'lang:system::lang.settings.label_smtp_port', 'string'],
            ['smtp_encryption', 'lang:system::lang.settings.label_smtp_encryption', 'required_if:protocol,smtp|string'],
            ['smtp_user', 'lang:system::lang.settings.label_smtp_user', 'string'],
            ['smtp_pass', 'lang:system::lang.settings.label_smtp_pass', 'string'],

            ['mailgun_domain', 'lang:system::lang.settings.label_smtp_pass', 'required_if:protocol,mailgun|string'],
            ['mailgun_secret', 'lang:system::lang.settings.label_smtp_pass', 'required_if:protocol,mailgun|string'],

            ['ses_key', 'lang:system::lang.settings.label_smtp_pass', 'required_if:protocol,ses|string'],
            ['ses_secret', 'lang:system::lang.settings.label_smtp_pass', 'required_if:protocol,ses|string'],
            ['ses_region', 'lang:system::lang.settings.label_smtp_pass', 'required_if:protocol,ses|string'],
        ],
    ],
];