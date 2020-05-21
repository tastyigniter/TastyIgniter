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
            ['location_id', 'admin::lang.reservations.text_restaurant', 'sometimes|required|integer'],
            ['first_name', 'admin::lang.reservations.label_first_name', 'required|between:1,48'],
            ['last_name', 'admin::lang.reservations.label_last_name', 'required|between:1,48'],
            ['email', 'admin::lang.label_email', 'required|email:filter|max:96'],
            ['telephone', 'admin::lang.reservations.label_customer_telephone', 'sometimes'],
            ['reserve_date', 'admin::lang.reservations.label_reservation_date', 'required|valid_date'],
            ['reserve_time', 'admin::lang.reservations.label_reservation_time', 'required|valid_time'],
            ['guest_num', 'admin::lang.reservations.label_guest', 'required|integer'],
        ];
    }
}