<?php

namespace Admin\Requests;

use System\Classes\FormRequest;

class StaffGroup extends FormRequest
{
    public function rules()
    {
        return [
            ['staff_group_name', 'admin::lang.label_name', 'required|between:2,128|unique:staff_groups'],
            ['description', 'admin::lang.label_description', 'string'],
            ['auto_assign', 'admin::lang.staff_groups.label_auto_assign', 'required|integer'],
            ['assignment_mode', 'admin::lang.staff_groups.label_assignment_mode', 'required_if:auto_assign,true|integer'],
            ['assignment_availability', 'admin::lang.staff_groups.label_assignment_availability', 'required_if:auto_assign,true|integer'],
            ['load_balanced_limit', 'admin::lang.staff_groups.label_load_balanced_limit', 'required_if:assignment_mode,2|integer'],
        ];
    }
}
