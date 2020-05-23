<?php

namespace Admin\Requests;

use System\Classes\FormRequest;

class Table extends FormRequest
{
    public function rules()
    {
        return [
            ['table_name', 'lang:admin::lang.label_name', 'required|min:2|max:255'],
            ['min_capacity', 'lang:admin::lang.tables.label_min_capacity', 'required|integer|min:1|lte:max_capacity'],
            ['max_capacity', 'lang:admin::lang.tables.label_capacity', 'required|integer|min:1|gte:min_capacity'],
            ['table_status', 'lang:admin::lang.label_status', 'required|boolean'],
        ];
    }
}