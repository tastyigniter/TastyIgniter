<?php

namespace Admin\Requests;

use System\Classes\FormRequest;

class StaffGroup extends FormRequest
{
    public function attributes()
    {
        return [
            'staff_group_name' => lang('admin::lang.label_name'),
            'description' => lang('admin::lang.label_description'),
            'auto_assign' => lang('admin::lang.staff_groups.label_auto_assign'),
            'assignment_mode' => lang('admin::lang.staff_groups.label_assignment_mode'),
            'assignment_availability' => lang('admin::lang.staff_groups.label_assignment_availability'),
            'load_balanced_limit' => lang('admin::lang.staff_groups.label_load_balanced_limit'),
        ];
    }

    public function rules()
    {
        return [
            'staff_group_name' => ['required', 'between:2,128', 'unique:staff_groups'],
            'description' => ['string'],
            'auto_assign' => ['required', 'integer'],
            'assignment_mode' => ['required_if:auto_assign,true', 'integer'],
            'assignment_availability' => ['required_if:auto_assign,true', 'integer'],
            'load_balanced_limit' => ['required_if:assignment_mode,2', 'integer'],
        ];
    }
}
