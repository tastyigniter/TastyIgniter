<?php

namespace Admin\Requests;

use System\Classes\FormRequest;

class StaffGroup extends FormRequest
{
    public function rules()
    {
        return [
            ['staff_group_name', 'admin::lang.label_name', 'required|between:2,128|unique:staff_groups'],
        ];
    }
}