<?php

namespace Admin\Requests;

use System\Classes\FormRequest;

class Reservation extends FormRequest
{
    protected function useDataFrom()
    {
        return static::DATA_TYPE_POST;
    }

    public function rules()
    {
        return [
            ['status_id', 'admin::lang.label_status', 'required|integer|exists:statuses,status_id'],
            ['location_id', 'admin::lang.reservations.text_restaurant', 'sometimes|required|integer'],
            ['statusData.status_id', 'admin::lang.reservations.label_status', 'required|same:status_id'],
            ['statusData.comment', 'admin::lang.reservations.label_comment', 'max:1500'],
            ['statusData.notify', 'admin::lang.reservations.label_notify', 'required|boolean'],
            ['assignee_id', 'admin::lang.reservations.label_assign_staff', 'required|integer'],
            ['first_name', 'admin::lang.reservations.label_first_name', 'required|between:2,32'],
            ['last_name', 'admin::lang.reservations.label_last_name', 'required|between:2,32'],
            ['email', 'admin::lang.label_email', 'required|email|max:96'],
            ['telephone', 'admin::lang.reservations.label_customer_telephone', 'sometimes'],
            ['reserve_date', 'admin::lang.reservations.label_reservation_date', 'required|valid_date'],
            ['reserve_time', 'admin::lang.reservations.label_reservation_time', 'required|valid_time'],
            ['guest_num', 'admin::lang.reservations.label_guest', 'required|integer'],
        ];
    }
}