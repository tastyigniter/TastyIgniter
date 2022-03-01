<?php

namespace Admin\Requests;

use System\Classes\FormRequest;

class UserRole extends FormRequest
{
    public function attributes()
    {
        return [
            'code' => lang('admin::lang.label_code'),
            'name' => lang('admin::lang.label_name'),
            'permissions' => lang('admin::lang.user_roles.label_permissions'),
            'permissions.*' => lang('admin::lang.user_roles.label_permissions'),
        ];
    }

    public function rules()
    {
        return [
            'code' => ['string', 'between:2,32', 'alpha_dash'],
            'name' => ['required', 'string', 'between:2,128'],
            'permissions' => ['required', 'array'],
            'permissions.*' => ['required', 'integer'],
        ];
    }
}
