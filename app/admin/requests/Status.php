<?php

namespace Admin\Requests;

use System\Classes\FormRequest;

class Status extends FormRequest
{
    public function rules()
    {
        return [
            ['status_name', 'admin::lang.label_name', 'required|min:2|max:32'],
            ['status_for', 'admin::lang.statuses.label_for', 'required|alpha'],
            ['status_color', 'admin::lang.statuses.label_color', 'max:7'],
            ['status_comment', 'admin::lang.statuses.label_comment', 'max:1028'],
            ['notify_customer', 'admin::lang.statuses.label_notify', 'required|boolean'],
        ];
    }
}
