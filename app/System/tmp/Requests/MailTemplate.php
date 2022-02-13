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
        $rules = [
            'layout_id' => ['integer'],
            'label' => ['required'],
            'subject' => ['required'],
        ];

        if (optional($this->getForm())->context == 'create') {
            $rules['code'] = ['required', 'min:2', 'max:32'];
        }

        return $rules;
    }
}
