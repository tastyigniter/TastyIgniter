<?php

namespace Admin\Requests;

use System\Classes\FormRequest;

class Ingredient extends FormRequest
{
    public function attributes()
    {
        return [
            'name' => lang('admin::lang.label_name'),
            'description' => lang('admin::lang.label_description'),
            'status' => lang('admin::lang.label_status'),
            'is_allergen' => lang('admin::lang.ingredients.label_allergen'),
        ];
    }

    public function rules()
    {
        return [
            'name' => ['required', 'between:2,128'],
            'description' => ['min:2'],
            'status' => ['boolean'],
            'is_allergen' => ['boolean'],
        ];
    }
}
