<?php

namespace System\Requests;

use System\Classes\FormRequest;

class MailLayout extends FormRequest
{
    public function rules()
    {
        return [
            ['name', 'admin::lang.label_name', 'required|between:2,32'],
        ];
    }
}
