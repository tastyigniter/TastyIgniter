<?php

namespace Admin\Requests;

use Admin\Facades\AdminAuth;
use System\Classes\FormRequest;

class Staff extends FormRequest
{
    public function rules()
    {
        $rules = [
            ['staff_name', 'admin::lang.label_name', 'required|between:2,128'],
            ['staff_email', 'admin::lang.label_email', 'required|max:96|email|unique:staffs,staff_email'],
            ['user.password', 'admin::lang.staff.label_password', ($this->getForm()->context == 'create' ? 'required' : 'sometimes')
                .'|between:6,32|same:user.password_confirm'],
            ['user.password_confirm', 'admin::lang.staff.label_confirm_password'],
        ];

        if (AdminAuth::isSuperUser()) {
            $rules = array_merge($rules, [
                ['user.username', 'admin::lang.staff.label_username', 'required|between:2,32|unique:users,username'],
                ['staff_status', 'admin::lang.label_status', 'boolean'],
                ['staff_group_id', 'admin::lang.staff.label_group', 'required|integer'],
                ['staff_location_id', 'admin::lang.staff.label_location', 'integer'],
            ]);
        }

        return $rules;
    }
}