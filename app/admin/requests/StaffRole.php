<?php

namespace Admin\Requests;

use System\Classes\FormRequest;

class StaffRole extends FormRequest
{
    public function attributes()
    {
        return [
            'code' => lang('admin::lang.label_code'),
            'name' => lang('admin::lang.label_name'),
            'permissions' => lang('admin::lang.staff_roles.label_permissions'),
            'permissions.*' => lang('admin::lang.staff_roles.label_permissions'),
        ];
    }

    public function rules()
    {
        return [
            'code' => ['between:2,32'],
            'name' => ['required', 'between:2,128', 'unique:staff_roles'],
            'permissions' => ['required', 'array'],
            'permissions.*' => ['required', 'integer'],
        ];
    }
}
