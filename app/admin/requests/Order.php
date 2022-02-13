<?php

namespace Admin\Requests;

use Illuminate\Support\Facades\Request;
use System\Classes\FormRequest;

class Order extends FormRequest
{
    protected function useDataFrom()
    {
        return static::DATA_TYPE_POST;
    }

    public function attributes()
    {
        return [
            'first_name' => lang('igniter.cart::default.checkout.label_first_name'),
            'last_name' => lang('igniter.cart::default.checkout.label_last_name'),
            'email' => lang('igniter.cart::default.checkout.label_email'),
            'telephone' => lang('igniter.cart::default.checkout.label_telephone'),
            'comment' => lang('igniter.cart::default.checkout.label_comment'),
            'payment' => lang('igniter.cart::default.checkout.label_payment_method'),
            'order_type' => lang('igniter.cart::default.checkout.label_order_type'),
            'address_id' => lang('igniter.cart::default.checkout.label_address'),
            'address.address_1' => lang('igniter.cart::default.checkout.label_address_1'),
            'address.address_2' => lang('igniter.cart::default.checkout.label_address_2'),
            'address.city' => lang('igniter.cart::default.checkout.label_city'),
            'address.state' => lang('igniter.cart::default.checkout.label_state'),
            'address.postcode' => lang('igniter.cart::default.checkout.label_postcode'),
            'address.country_id' => lang('igniter.cart::default.checkout.label_country'),
        ];
    }

    public function rules()
    {
        $method = Request::method();

        $rules = [
            'first_name' => ['between:1,48'],
            'last_name' => ['between:1,48'],
            'email' => ['sometimes', 'required', 'email:filter', 'max:96'],
            'comment' => ['max:500'],
            'payment' => ['sometimes', 'required', 'alpha_dash'],
        ];

        if ($method == 'post') {
            $rules['first_name'][] = 'required';
            $rules['last_name'][] = 'required';
            $rules['order_type'][] = 'required';
        }

        if (Request::input('order_type', 'collection') == 'delivery') {
            $rules['address_id'] = ['required', 'integer'];
            $rules['address.address_1'] = ['required', 'min:3', 'max:128'];
            $rules['address.address_2'] = ['sometimes', 'min:3', 'max:128'];
            $rules['address.city'] = ['sometimes', 'min:2', 'max:128'];
            $rules['address.state'] = ['sometimes', 'max:128'];
            $rules['address.postcode'] = ['string'];
            $rules['address.country_id'] = ['sometimes', 'required', 'integer'];
        }

        return $rules;
    }
}
