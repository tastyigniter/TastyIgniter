<?php

namespace System\Requests;

use System\Classes\FormRequest;

class Permission extends FormRequest
{
    public function rules()
    {
        return [
            ['name', 'lang:admin::lang.label_name', 'sometimes|required|min:2|max:128|regex:/^[a-zA-Z_]+\.[a-zA-Z_]+$/'],
            ['description', 'lang:admin::lang.label_description', 'required|max:255'],
            ['action.*', 'lang:system::lang.permissions.label_action', 'required|alpha'],
            ['status', 'lang:admin::lang.label_status', 'required|integer'],
        ];
    }

    public function messages()
    {
        return [
            'name.regex' => lang('system::lang.permissions.error_invalid_name'),
        ];
    }
}