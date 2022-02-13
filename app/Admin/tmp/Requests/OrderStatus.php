<?php

namespace Admin\Requests;

use System\Classes\FormRequest;

class OrderStatus extends FormRequest
{
    public function attributes()
    {
        return [
            'status_id' => lang('admin::lang.label_status'),
            'comment' => lang('admin::lang.statuses.label_comment'),
            'notify' => lang('admin::lang.statuses.label_notify'),

            'assignee_group_id' => lang('admin::lang.statuses.label_assignee_group'),
            'assignee_id' => lang('admin::lang.statuses.label_assignee'),
        ];
    }

    public function rules()
    {
        return [
            'status_id' => ['sometimes', 'required', 'integer', 'exists:statuses'],
            'comment' => ['max:1500'],
            'notify' => ['sometimes', 'required', 'boolean'],

            'assignee_group_id' => ['sometimes', 'required', 'integer', 'exists:staff_groups,staff_group_id'],
            'assignee_id' => ['integer', 'exists:staffs,staff_id'],
        ];
    }

    protected function useDataFrom()
    {
        return static::DATA_TYPE_POST;
    }
}
