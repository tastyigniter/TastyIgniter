<?php

namespace System\Requests;

use System\Classes\FormRequest;

class MailSettings extends FormRequest
{
    public function attributes()
    {
        return [
            'sender_name' => lang('system::lang.settings.label_sender_name'),
            'sender_email' => lang('system::lang.settings.label_sender_email'),
            'protocol' => lang('system::lang.settings.label_protocol'),

            'mail_logo' => lang('system::lang.settings.label_mail_logo'),
            'sendmail_path' => lang('system::lang.settings.label_sendmail_path'),

            'smtp_host' => lang('system::lang.settings.label_smtp_host'),
            'smtp_port' => lang('system::lang.settings.label_smtp_port'),
            'smtp_encryption' => lang('system::lang.settings.label_smtp_encryption'),
            'smtp_user' => lang('system::lang.settings.label_smtp_user'),
            'smtp_pass' => lang('system::lang.settings.label_smtp_pass'),

            'mailgun_domain' => lang('system::lang.settings.label_mailgun_domain'),
            'mailgun_secret' => lang('system::lang.settings.label_mailgun_secret'),

            'postmark_token' => lang('system::lang.settings.label_postmark_token'),

            'ses_key' => lang('system::lang.settings.label_ses_key'),
            'ses_secret' => lang('system::lang.settings.label_ses_secret'),
            'ses_region' => lang('system::lang.settings.label_ses_region'),
        ];
    }

    public function rules()
    {
        return [
            'sender_name' => ['required', 'string'],
            'sender_email' => ['required', 'email:filter'],
            'protocol' => ['required', 'string'],

            'mail_logo' => ['string'],
            'sendmail_path' => ['required_if:protocol,sendmail', 'string'],

            'smtp_host' => ['string'],
            'smtp_port' => ['string'],
            'smtp_user' => ['string'],
            'smtp_pass' => ['string'],

            'mailgun_domain' => ['required_if:protocol,mailgun', 'string'],
            'mailgun_secret' => ['required_if:protocol,mailgun', 'string'],

            'postmark_token' => ['required_if:protocol,postmark', 'string'],

            'ses_key' => ['required_if:protocol,ses', 'string'],
            'ses_secret' => ['required_if:protocol,ses', 'string'],
            'ses_region' => ['required_if:protocol,ses', 'string'],
        ];
    }
}
