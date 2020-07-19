<?php

namespace System\Requests;

use System\Classes\FormRequest;

class MailPartial extends FormRequest
{
    public function rules()
    {
        return [
            ['name', 'admin::lang.label_name', 'required'],
            ['code', 'system::lang.mail_templates.label_code', 'sometimes|required|unique:mail_partials'],
            ['html', 'system::lang.mail_templates.label_html', 'required'],
            ['text', 'system::lang.mail_templates.label_plain'],
        ];
    }
}