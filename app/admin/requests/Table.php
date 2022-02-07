<?php

namespace Admin\Requests;

use System\Classes\FormRequest;

class Table extends FormRequest
{
    public function attributes()
    {
        return [
            'table_name' => lang('admin::lang.label_name'),
            'min_capacity' => lang('admin::lang.tables.label_min_capacity'),
            'max_capacity' => lang('admin::lang.tables.label_capacity'),
            'extra_capacity' => lang('admin::lang.tables.label_extra_capacity'),
            'priority' => lang('admin::lang.tables.label_priority'),
            'is_joinable' => lang('admin::lang.tables.label_joinable'),
            'table_status' => lang('admin::lang.label_status'),
            'locations' => lang('admin::lang.label_location'),
            'locations.*' => lang('admin::lang.label_location'),
        ];
    }

    public function rules()
    {
        return [
            'table_name' => ['required', 'min:2', 'max:255'],
            'min_capacity' => ['required', 'integer', 'min:1', 'lte:max_capacity'],
            'max_capacity' => ['required', 'integer', 'min:1', 'gte:min_capacity'],
            'extra_capacity' => ['required', 'integer'],
            'priority' => ['required', 'integer'],
            'is_joinable' => ['required', 'boolean'],
            'table_status' => ['required', 'boolean'],
            'locations' => ['required'],
            'locations.*' => ['integer'],
        ];
    }
}
