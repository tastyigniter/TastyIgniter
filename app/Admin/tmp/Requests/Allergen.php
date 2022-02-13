<?php

namespace Admin\Requests;

use System\Classes\FormRequest;

class Allergen extends FormRequest
{
    public function attributes()
    {
        return [
            'name' => lang('admin::lang.label_name'),
            'description' => lang('admin::lang.label_description'),
            'status' => lang('admin::lang.label_status'),
        ];
    }

    public function rules()
    {
        return [
            'name' => ['required', 'between:2,128'],
            'description' => ['min:2'],
            'status' => ['boolean'],
        ];
    }
}
