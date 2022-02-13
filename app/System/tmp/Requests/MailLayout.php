<?php

namespace System\Requests;

use System\Classes\FormRequest;

class MailLayout extends FormRequest
{
    public function attributes()
    {
        return [
            'name' => lang('admin::lang.label_name'),
        ];
    }

    public function rules()
    {
        return [
            'name' => ['required', 'between:2,32'],
        ];
    }
}
