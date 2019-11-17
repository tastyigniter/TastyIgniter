<?php

namespace Admin\Requests;

use System\Classes\FormRequest;

class StaffGroup extends FormRequest
{
    public function rules()
    {
        return [
            ['staff_group_name', 'admin::lang.label_name', 'required|between:2,32'],
            ['customer_account_access', 'admin::lang.staff_groups.label_customer_account_access', 'required|boolean'],
            ['location_access', 'admin::lang.staff_groups.label_location_access', 'required|boolean'],
            ['permissions.*.*', 'Permission', 'string'],
        ];
    }
}