<?php

namespace System\Requests;

use System\Classes\FormRequest;

class MailPartial extends FormRequest
{
    public function attributes()
    {
        return [
            'name' => lang('admin::lang.label_name'),
            'code' => lang('system::lang.mail_templates.label_code'),
            'html' => lang('system::lang.mail_templates.label_html'),
        ];
    }

    public function rules()
    {
        return [
            'name' => ['required'],
            'code' => ['sometimes', 'required', 'regex:/^[a-z-_\.\:]+$/i', 'unique:mail_partials'],
            'html' => ['required'],
        ];
    }
}
