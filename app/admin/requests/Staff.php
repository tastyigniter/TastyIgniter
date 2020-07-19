<?php

namespace Admin\Requests;

use System\Classes\FormRequest;

class Staff extends FormRequest
{
    public function rules()
    {
        $rules = [
            ['staff_name', 'admin::lang.label_name', 'required|between:2,128'],
            ['staff_email', 'admin::lang.label_email', 'required|max:96|email:filter|unique:staffs,staff_email'],
            ['user.username', 'admin::lang.staff.label_username', 'required|between:2,32|unique:users,username'],
            ['user.password', 'admin::lang.staff.label_password', ($this->getForm()->context == 'create' ? 'required' : 'sometimes')
                .'|between:6,32|same:user.password_confirm'],
            ['user.password_confirm', 'admin::lang.staff.label_confirm_password'],
        ];

        if ($this->getForm()->context != 'account') {
            $rules = array_merge($rules, [
                ['staff_status', 'admin::lang.label_status', 'boolean'],
                ['language_id', 'admin::lang.staff.', 'integer'],
                ['staff_role_id', 'admin::lang.staff.label_role', 'required|integer'],
                ['groups', 'admin::lang.staff.label_group', 'required|array'],
                ['locations', 'admin::lang.staff.label_location', 'required|array'],
                ['groups.*', 'admin::lang.staff.label_group', 'integer'],
                ['locations.*', 'admin::lang.staff.label_location', 'integer'],
            ]);
        }

        return $rules;
    }
}