<?php

namespace Admin\Requests;

use System\Classes\FormRequest;

class WorkingHour extends FormRequest
{
    public function attributes()
    {
        return [
            'type' => lang('admin::lang.locations.label_schedule_type'),
            'days.*' => lang('admin::lang.locations.label_schedule_days'),
            'open' => lang('admin::lang.locations.label_schedule_open'),
            'close' => lang('admin::lang.locations.label_schedule_close'),
            'timesheet' => lang('admin::lang.locations.text_timesheet'),
            'flexible.*.day' => lang('admin::lang.locations.label_schedule_days'),
            'flexible.*.hours' => lang('admin::lang.locations.label_schedule_hours'),
            'flexible.*.status' => lang('admin::lang.label_status'),
        ];
    }

    public function rules()
    {
        return [
            'type' => ['alpha_dash', 'in:24_7,daily,timesheet,flexible'],
            'days.*' => ['required_if:type,daily', 'integer', 'between:0,7'],
            'open' => ['required_if:type,daily', 'valid_time'],
            'close' => ['required_if:type,daily', 'valid_time'],
            'timesheet' => ['required_if:type,timesheet', 'string'],
            'flexible.*.day' => ['required_if:type,flexible', 'numeric'],
            'flexible.*.hours' => ['required_if:type,flexible'],
            'flexible.*.status' => ['sometimes', 'required_if:type,flexible', 'boolean'],
        ];
    }

    protected function useDataFrom()
    {
        return static::DATA_TYPE_POST;
    }
}
