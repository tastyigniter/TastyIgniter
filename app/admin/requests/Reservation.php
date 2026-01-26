<?php

namespace Admin\Requests;

use System\Classes\FormRequest;

class Reservation extends FormRequest
{
    public function attributes()
    {
        return [
            'location_id' => lang('admin::lang.reservations.text_restaurant'),
            'first_name' => lang('admin::lang.reservations.label_first_name'),
            'last_name' => lang('admin::lang.reservations.label_last_name'),
            'email' => lang('admin::lang.label_email'),
            'telephone' => lang('admin::lang.reservations.label_customer_telephone'),
            'reserve_date' => lang('admin::lang.reservations.label_reservation_date'),
            'reserve_time' => lang('admin::lang.reservations.label_reservation_time'),
            'guest_num' => lang('admin::lang.reservations.label_guest'),
        ];
    }

    public function rules()
    {
        $method = Request::method();

        $rules = [
            'location_id' => ['integer'],
            'first_name' => ['between:1,48'],
            'last_name' => ['between:1,48'],
            'email' => ['email:filter', 'max:96'],
            'telephone' => ['sometimes'],
            'reserve_date' => ['valid_date'],
            'reserve_time' => ['valid_time'],
            'guest_num' => ['integer', 'min:1'],
            'duration' => ['integer', 'min:1'],
        ];

        if ($method === 'POST') {
            $rules['location_id'][] = 'required';
            $rules['first_name'][] = 'required';
            $rules['last_name'][] = 'required';
            $rules['reserve_date'][] = 'required';
            $rules['reserve_time'][] = 'required';
            $rules['guest_num'][] = 'required';
        }

        return $rules;
    }
}
