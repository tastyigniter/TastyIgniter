<?php

namespace Admin\Requests;

use System\Classes\FormRequest;

class UserGroup extends FormRequest
{
    public function attributes()
    {
        return [
            'user_group_name' => lang('admin::lang.label_name'),
            'description' => lang('admin::lang.label_description'),
            'auto_assign' => lang('admin::lang.user_groups.label_auto_assign'),
            'auto_assign_mode' => lang('admin::lang.user_groups.label_assignment_mode'),
            'auto_assign_limit' => lang('admin::lang.user_groups.label_load_balanced_limit'),
            'auto_assign_availability' => lang('admin::lang.user_groups.label_assignment_availability'),
        ];
    }

    public function rules()
    {
        return [
            'user_group_name' => ['required', 'string', 'between:2,128', 'unique:user_groups'],
            'description' => ['string'],
            'auto_assign' => ['required', 'boolean'],
            'auto_assign_mode' => ['required_if:auto_assign,true', 'integer', 'max:2'],
            'auto_assign_limit' => ['required_if:auto_assign_mode,2', 'integer', 'max:99'],
            'auto_assign_availability' => ['required_if:auto_assign,true', 'boolean'],
        ];
    }
}
