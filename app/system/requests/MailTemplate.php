<?php

namespace System\Requests;

use System\Classes\FormRequest;

class MailTemplate extends FormRequest
{
    public function rules()
    {
        $rules[] = ['layout_id', 'system::lang.mail_templates.label_layout', 'integer'];
        $rules[] = ['label', 'admin::lang.label_description', 'required'];
        $rules[] = ['subject', 'system::lang.mail_templates.label_code', 'required'];

        if ($this->getForm()->context == 'create') {
            $rules[] = ['code', 'system::lang.mail_templates.label_code', 'required|min:2|max:32'];
        }

        return $rules;
    }
}
