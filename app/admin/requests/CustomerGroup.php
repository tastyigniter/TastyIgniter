<?php

namespace Admin\Requests;

use System\Classes\FormRequest;

class CustomerGroup extends FormRequest
{
    public function rules()
    {
        return [
            ['group_name', 'admin::lang.label_name', 'required|between:2,32'],
            ['approval', 'admin::lang.customer_groups.label_approval', 'required|boolean'],
            ['description', 'admin::lang.label_description', 'between:2,512'],
        ];
    }
}
