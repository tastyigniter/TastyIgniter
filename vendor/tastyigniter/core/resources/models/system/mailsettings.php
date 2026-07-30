<?php

return [
    'form' => [
        'toolbar' => [
            'buttons' => [
                'save' => [
                    'label' => 'lang:igniter::admin.button_save',
                    'class' => 'btn btn-primary',
                    'data-request' => 'onSave',
                    'data-progress-indicator' => 'igniter::admin.text_saving',
                ],
            ],
        ],
        'fields' => [
            'sender_name' => [
                'label' => 'igniter::system.settings.label_sender_name',
                'type' => 'text',
                'span' => 'left',
            ],
            'sender_email' => [
                'label' => 'igniter::system.settings.label_sender_email',
                'type' => 'text',
                'span' => 'right',
            ],
            'protocol' => [
                'label' => 'igniter::system.settings.label_protocol',
                'type' => 'select',
                'default' => 'sendmail',
                'span' => 'left',
                'options' => [
                    'log' => 'igniter::system.settings.text_log_file',
                    'sendmail' => 'igniter::system.settings.text_sendmail',
                    'smtp' => 'igniter::system.settings.text_smtp',
                    'mailgun' => 'igniter::system.settings.text_mailgun',
                    'postmark' => 'igniter::system.settings.text_postmark',
                    'ses' => 'igniter::system.settings.text_ses',
                ],
            ],
            'mail_logo' => [
                'label' => 'igniter::system.settings.label_mail_logo',
                'type' => 'mediafinder',
                'span' => 'right',
                'mode' => 'inline',
                'comment' => 'igniter::system.settings.help_mail_logo',
            ],

            'smtp_host' => [
                'label' => 'igniter::system.settings.label_smtp_host',
                'type' => 'text',
                'trigger' => [
                    'action' => 'show',
                    'field' => 'protocol',
                    'condition' => 'value[smtp]',
                ],
            ],
            'smtp_port' => [
                'label' => 'igniter::system.settings.label_smtp_port',
                'type' => 'text',
                'span' => 'left',
                'trigger' => [
                    'action' => 'show',
                    'field' => 'protocol',
                    'condition' => 'value[smtp]',
                ],
            ],
            'smtp_encryption' => [
                'label' => 'igniter::system.settings.label_smtp_encryption',
                'type' => 'select',
                'default' => 'tls',
                'span' => 'right',
                'options' => [
                    '' => 'igniter::system.settings.text_mail_no_encryption',
                    'tls' => 'igniter::system.settings.text_mail_tls_encryption',
                    'ssl' => 'igniter::system.settings.text_mail_ssl_encryption',
                ],
                'trigger' => [
                    'action' => 'show',
                    'field' => 'protocol',
                    'condition' => 'value[smtp]',
                ],
            ],
            'smtp_user' => [
                'label' => 'igniter::system.settings.label_smtp_user',
                'type' => 'text',
                'span' => 'left',
                'trigger' => [
                    'action' => 'show',
                    'field' => 'protocol',
                    'condition' => 'value[smtp]',
                ],
            ],
            'smtp_pass' => [
                'label' => 'igniter::system.settings.label_smtp_pass',
                'type' => 'text',
                'span' => 'right',
                'trigger' => [
                    'action' => 'show',
                    'field' => 'protocol',
                    'condition' => 'value[smtp]',
                ],
            ],

            'mailgun_domain' => [
                'label' => 'igniter::system.settings.label_mailgun_domain',
                'type' => 'text',
                'span' => 'left',
                'trigger' => [
                    'action' => 'show',
                    'field' => 'protocol',
                    'condition' => 'value[mailgun]',
                ],
            ],
            'mailgun_secret' => [
                'label' => 'igniter::system.settings.label_mailgun_secret',
                'type' => 'text',
                'span' => 'right',
                'trigger' => [
                    'action' => 'show',
                    'field' => 'protocol',
                    'condition' => 'value[mailgun]',
                ],
            ],

            'postmark_token' => [
                'label' => 'igniter::system.settings.label_postmark_token',
                'type' => 'text',
                'trigger' => [
                    'action' => 'show',
                    'field' => 'protocol',
                    'condition' => 'value[postmark]',
                ],
            ],

            'ses_key' => [
                'label' => 'igniter::system.settings.label_ses_key',
                'type' => 'text',
                'trigger' => [
                    'action' => 'show',
                    'field' => 'protocol',
                    'condition' => 'value[ses]',
                ],
            ],
            'ses_secret' => [
                'label' => 'igniter::system.settings.label_ses_secret',
                'type' => 'text',
                'trigger' => [
                    'action' => 'show',
                    'field' => 'protocol',
                    'condition' => 'value[ses]',
                ],
            ],
            'ses_region' => [
                'label' => 'igniter::system.settings.label_ses_region',
                'type' => 'text',
                'trigger' => [
                    'action' => 'show',
                    'field' => 'protocol',
                    'condition' => 'value[ses]',
                ],
            ],
            'test_email' => [
                'label' => 'igniter::system.settings.label_test_email',
                'type' => 'partial',
                'path' => 'settings/test_email_button',
                'span' => 'left',
            ],
        ],
    ],
];
