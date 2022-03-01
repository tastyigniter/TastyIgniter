<?php

namespace Admin\Requests;

use System\Classes\FormRequest;

class CustomerGroup extends FormRequest
{
    public function attributes()
    {
        return [
            'group_name' => lang('admin::lang.label_name'),
            'approval' => lang('admin::lang.customer_groups.label_approval'),
            'description' => lang('admin::lang.label_description'),
        ];
    }

    public function rules()
    {
        return [
            'group_name' => ['required', 'string', 'between:2,32'],
            'approval' => ['required', 'boolean'],
            'description' => ['string', 'between:2,512'],
        ];
    }
}
