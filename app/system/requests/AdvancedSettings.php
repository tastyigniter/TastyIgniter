<?php

namespace System\Requests;

use System\Classes\FormRequest;

class AdvancedSettings extends FormRequest
{
    public function attributes()
    {
        return [
            'enable_request_log' => lang('system::lang.settings.label_enable_request_log'),
            'maintenance_mode' => lang('system::lang.settings.label_maintenance_mode'),
            'maintenance_message' => lang('system::lang.settings.label_maintenance_message'),
            'activity_log_timeout' => lang('system::lang.settings.label_activity_log_timeout'),
        ];
    }

    public function rules()
    {
        return [
            'enable_request_log' => ['required', 'boolean'],
            'maintenance_mode' => ['required', 'boolean'],
            'maintenance_message' => ['required_if:maintenance_mode,1', 'string'],
            'activity_log_timeout' => ['required', 'integer', 'max:999'],
        ];
    }
}
