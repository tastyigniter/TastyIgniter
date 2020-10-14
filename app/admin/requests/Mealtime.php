<?php

namespace Admin\Requests;

use System\Classes\FormRequest;

class Mealtime extends FormRequest
{
    public function rules()
    {
        return [
            ['mealtime_name', 'admin::lang.mealtimes.label_mealtime_name', 'required|between:2,128'],
            ['start_time', 'admin::lang.mealtimes.label_start_time', 'required|valid_time'],
            ['end_time', 'admin::lang.mealtimes.label_end_time', 'required|valid_time'],
            ['mealtime_status', 'admin::lang.label_status', 'required|boolean'],
            ['locations.*', 'lang:admin::lang.label_location', 'integer'],
        ];
    }
}
