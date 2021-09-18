<?php

namespace Admin\Requests;

use System\Classes\FormRequest;

class Staff extends FormRequest
{
    public function rules()
    {
        $passwordRule = optional($this->getForm())->context != 'create'
            ? 'sometimes' : 'required_if:user.send_invite,0';

        $rules = [
            ['staff_name', 'admin::lang.label_name', 'required|between:2,128'],
            ['staff_email', 'admin::lang.label_email', 'required|max:96|email:filter|unique:staffs,staff_email'],
            ['user.username', 'admin::lang.staff.label_username', 'required|alpha_dash|between:2,32|unique:users,username'],
            ['user.password', 'admin::lang.staff.label_password', $passwordRule.'|between:6,32|same:user.password_confirm'],
            ['user.password_confirm', 'admin::lang.staff.label_confirm_password'],
        ];

        if (optional($this->getForm())->context != 'account') {
            $rules = array_merge($rules, [
                ['staff_status', 'admin::lang.label_status', 'boolean'],
                ['language_id', 'admin::lang.staff.label_language_id', 'nullable|integer'],
                ['staff_role_id', 'admin::lang.staff.label_role', 'sometimes|required|integer'],
                ['groups', 'admin::lang.staff.label_group', 'required|array'],
                ['locations', 'admin::lang.staff.label_location', 'nullable|array'],
                ['groups.*', 'admin::lang.staff.label_group', 'integer'],
                ['locations.*', 'admin::lang.staff.label_location', 'integer'],
            ]);
        }

        return $rules;
    }
}
