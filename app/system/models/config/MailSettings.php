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
                    'data-request' => 'onSave',
                    'data-progress-indicator' => 'admin::lang.text_saving',
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
                'span' => 'left',
                'options' => [
                    'log' => 'lang:system::lang.settings.text_log_file',
                    'sendmail' => 'lang:system::lang.settings.text_sendmail',
                    'smtp' => 'lang:system::lang.settings.text_smtp',
                    'mailgun' => 'lang:system::lang.settings.text_mailgun',
                    'postmark' => 'lang:system::lang.settings.text_postmark',
                    'ses' => 'lang:system::lang.settings.text_ses',
                ],
            ],
            'mail_logo' => [
                'label' => 'lang:system::lang.settings.label_mail_logo',
                'type' => 'mediafinder',
                'span' => 'right',
                'mode' => 'inline',
                'comment' => 'lang:system::lang.settings.help_mail_logo',
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

            'postmark_token' => [
                'label' => 'lang:system::lang.settings.label_postmark_token',
                'type' => 'text',
                'trigger' => [
                    'action' => 'show',
                    'field' => 'protocol',
                    'condition' => 'value[postmark]',
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
    ],
];
