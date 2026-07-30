<?php

declare(strict_types=1);

namespace Igniter\System\Http\Requests;

use Igniter\System\Classes\FormRequest;
use Override;

class MailSettingsRequest extends FormRequest
{
    #[Override]
    public function attributes(): array
    {
        return [
            'sender_name' => lang('igniter::system.settings.label_sender_name'),
            'sender_email' => lang('igniter::system.settings.label_sender_email'),
            'protocol' => lang('igniter::system.settings.label_protocol'),

            'mail_logo' => lang('igniter::system.settings.label_mail_logo'),

            'smtp_host' => lang('igniter::system.settings.label_smtp_host'),
            'smtp_port' => lang('igniter::system.settings.label_smtp_port'),
            'smtp_encryption' => lang('igniter::system.settings.label_smtp_encryption'),
            'smtp_user' => lang('igniter::system.settings.label_smtp_user'),
            'smtp_pass' => lang('igniter::system.settings.label_smtp_pass'),

            'mailgun_domain' => lang('igniter::system.settings.label_mailgun_domain'),
            'mailgun_secret' => lang('igniter::system.settings.label_mailgun_secret'),

            'postmark_token' => lang('igniter::system.settings.label_postmark_token'),

            'ses_key' => lang('igniter::system.settings.label_ses_key'),
            'ses_secret' => lang('igniter::system.settings.label_ses_secret'),
            'ses_region' => lang('igniter::system.settings.label_ses_region'),
        ];
    }

    public function rules(): array
    {
        return [
            'sender_name' => ['required', 'string'],
            'sender_email' => ['required', 'email:filter'],
            'protocol' => ['required', 'string'],

            'mail_logo' => ['nullable', 'string'],

            'smtp_host' => ['nullable', 'required_if:protocol,smtp', 'string'],
            'smtp_port' => ['nullable', 'required_if:protocol,smtp', 'string'],
            'smtp_user' => ['nullable', 'string'],
            'smtp_pass' => ['nullable', 'string'],

            'mailgun_domain' => ['nullable', 'required_if:protocol,mailgun', 'string'],
            'mailgun_secret' => ['nullable', 'required_if:protocol,mailgun', 'string'],

            'postmark_token' => ['nullable', 'required_if:protocol,postmark', 'string'],

            'ses_key' => ['nullable', 'required_if:protocol,ses', 'string'],
            'ses_secret' => ['nullable', 'required_if:protocol,ses', 'string'],
            'ses_region' => ['nullable', 'required_if:protocol,ses', 'string'],
        ];
    }
}
