<?php

namespace Admin\Requests;

use System\Classes\FormRequest;

class Staff extends FormRequest
{
    public function attributes()
    {
        return [
            'staff_name' => lang('admin::lang.label_name'),
            'staff_email' => lang('admin::lang.label_email'),
            'user.username' => lang('admin::lang.staff.label_username'),
            'user.password' => lang('admin::lang.staff.label_password'),
            'user.password_confirm' => lang('admin::lang.staff.label_confirm_password'),
            'staff_status' => lang('admin::lang.label_status'),
            'language_id' => lang('admin::lang.staff.label_language_id'),
            'staff_role_id' => lang('admin::lang.staff.label_role'),
            'groups' => lang('admin::lang.staff.label_group'),
            'locations' => lang('admin::lang.staff.label_location'),
            'groups.*' => lang('admin::lang.staff.label_group'),
            'locations.*' => lang('admin::lang.staff.label_location'),
        ];
    }

    public function rules()
    {
        $passwordRule = optional($this->getForm())->context != 'create'
            ? 'sometimes' : 'required_if:user.send_invite,0';

        $rules = [
            'staff_name' => ['required', 'between:2,128', 'unique:staffs'],
            'staff_email' => ['required', 'max:96', 'email:filter', 'unique:staffs'],
            'user.username' => ['required', 'alpha_dash', 'between:2,32', 'unique:users,username'],
            'user.password' => [$passwordRule, 'between:6,32', 'same:user.password_confirm'],
        ];

        if (optional($this->getForm())->context != 'account') {
            $rules = array_merge($rules, [
                'staff_status' => ['boolean'],
                'language_id' => ['nullable', 'integer'],
                'staff_role_id' => ['sometimes', 'required', 'integer'],
                'groups' => ['required', 'array'],
                'locations' => ['nullable', 'array'],
                'groups.*' => ['integer'],
                'locations.*' => ['integer'],
            ]);
        }

        return $rules;
    }
}
