<?php

namespace Admin\Requests;

use System\Classes\FormRequest;

class Status extends FormRequest
{
    public function attributes()
    {
        return [
            'status_name' => lang('admin::lang.label_name'),
            'status_for' => lang('admin::lang.statuses.label_for'),
            'status_color' => lang('admin::lang.statuses.label_color'),
            'status_comment' => lang('admin::lang.statuses.label_comment'),
            'notify_customer' => lang('admin::lang.statuses.label_notify'),
        ];
    }

    public function rules()
    {
        return [
            'status_name' => ['required', 'min:2', 'max:32'],
            'status_for' => ['required', 'alpha'],
            'status_color' => ['max:7'],
            'status_comment' => ['max:1028'],
            'notify_customer' => ['required', 'boolean'],
        ];
    }
}
