<?php

namespace Admin\Requests;

use System\Classes\FormRequest;

class Category extends FormRequest
{
    public function attributes()
    {
        return [
            'name' => lang('admin::lang.label_name'),
            'description' => lang('admin::lang.label_description'),
            'permalink_slug' => lang('admin::lang.categories.label_permalink_slug'),
            'parent_id' => lang('admin::lang.categories.label_parent'),
            'priority' => lang('admin::lang.categories.label_priority'),
            'status' => lang('admin::lang.label_status'),
            'locations.*' => lang('admin::lang.column_location'),
        ];
    }

    public function rules()
    {
        return [
            'name' => ['required', 'between:2,128'],
            'description' => ['min:2'],
            'permalink_slug' => ['alpha_dash', 'max:255'],
            'parent_id' => ['nullable', 'integer'],
            'priority' => ['nullable', 'integer'],
            'status' => ['boolean'],
            'locations.*' => ['integer'],
        ];
    }
}
