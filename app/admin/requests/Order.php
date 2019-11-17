<?php

namespace Admin\Requests;

use System\Classes\FormRequest;

class Order extends FormRequest
{
    protected function useDataFrom()
    {
        return static::DATA_TYPE_POST;
    }

    public function rules()
    {
        return [
            ['status_id', 'admin::lang.label_status', 'required|integer|exists:statuses'],
            ['statusData.status_id', 'admin::lang.orders.label_status', 'required|same:status_id'],
            ['statusData.comment', 'admin::lang.orders.label_comment', 'max:1500'],
            ['statusData.notify', 'admin::lang.orders.label_notify', 'required|boolean'],
            ['assignee_id', 'admin::lang.orders.label_assign_staff', 'required|integer'],
        ];
    }
}