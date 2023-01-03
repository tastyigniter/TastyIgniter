<?php

namespace System\Requests;

use System\Classes\FormRequest;

class MailTemplate extends FormRequest
{
    public function attributes()
    {
        return [
            'layout_id' => lang('system::lang.mail_templates.label_layout'),
            'label' => lang('admin::lang.label_description'),
            'subject' => lang('system::lang.mail_templates.label_subject'),
            'code' => lang('system::lang.mail_templates.label_code'),
        ];
    }

    public function rules()
    {
        return [
            'code' => ['sometimes', 'required', 'min:2', 'max:128', 'unique:mail_templates', 'regex:/^[a-z-_\.\:]+$/i'],
            'layout_id' => ['integer'],
            'label' => ['required'],
            'subject' => ['required'],
        ];
    }
}
