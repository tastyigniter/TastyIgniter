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
            'subject' => lang('system::lang.mail_templates.label_code'),
            'code' => lang('system::lang.mail_templates.label_code'),
        ];
    }

    public function rules()
    {
        return [
            'layout_id' => ['integer'],
            'code' => ['sometimes', 'required', 'min:2', 'max:32'],
            'label' => ['required', 'string'],
            'subject' => ['required', 'string'],
            'body' => ['string'],
            'plain_body' => ['string'],
        ];
    }
}
