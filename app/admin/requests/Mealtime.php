<?php

namespace Admin\Requests;

use System\Classes\FormRequest;

class Mealtime extends FormRequest
{
    public function attributes()
    {
        return [
            'mealtime_name' => lang('admin::lang.mealtimes.label_mealtime_name'),
            'start_time' => lang('admin::lang.mealtimes.label_start_time'),
            'end_time' => lang('admin::lang.mealtimes.label_end_time'),
            'mealtime_status' => lang('admin::lang.label_status'),
            'locations.*' => lang('admin::lang.label_location'),
        ];
    }

    public function rules()
    {
        return [
            'mealtime_name' => ['required', 'between:2,128'],
            'start_time' => ['required', 'valid_time'],
            'end_time' => ['required', 'valid_time'],
            'mealtime_status' => ['required', 'boolean'],
            'locations.*' => ['integer'],
        ];
    }
}
