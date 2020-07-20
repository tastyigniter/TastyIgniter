<?php

namespace Admin\Requests;

use System\Classes\FormRequest;

class StaffRole extends FormRequest
{
    public function rules()
    {
        return [
            ['code', 'admin::lang.label_code', 'between:2,32'],
            ['name', 'admin::lang.label_name', 'required|between:2,128'],
            ['permissions', 'admin::lang.staff_roles.label_permissions', 'required|array'],
            ['permissions.*', 'admin::lang.staff_roles.label_permissions', 'required|integer'],
        ];
    }
}
