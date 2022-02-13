<?php

namespace Admin\Requests;

use System\Classes\FormRequest;

class Customer extends FormRequest
{
    public function attributes()
    {
        return [
            'first_name' => lang('admin::lang.customers.label_first_name'),
            'last_name' => lang('admin::lang.customers.label_last_name'),
            'email' => lang('admin::lang.label_email'),
            'telephone' => lang('admin::lang.customers.label_telephone'),
            'newsletter' => lang('admin::lang.customers.label_newsletter'),
            'customer_group_id' => lang('admin::lang.customers.label_customer_group'),
            'status' => lang('admin::lang.label_status'),
            'addresses.*.address_1' => lang('admin::lang.customers.label_address_1'),
            'addresses.*.city' => lang('admin::lang.customers.label_city'),
            'addresses.*.state' => lang('admin::lang.customers.label_state'),
            'addresses.*.postcode' => lang('admin::lang.customers.label_postcode'),
            'addresses.*.country_id' => lang('admin::lang.customers.label_country'),
            'password' => lang('admin::lang.customers.label_password'),
            '_confirm_password' => lang('admin::lang.customers.label_confirm_password'),
        ];
    }

    public function rules()
    {
        $rules = [
            'first_name' => ['required', 'between:1,48'],
            'last_name' => ['required', 'between:1,48'],
            'email' => ['required', 'email:filter', 'max:96', 'unique:customers,email'],
            'telephone' => ['sometimes'],
            'newsletter' => ['sometimes', 'required', 'boolean'],
            'customer_group_id' => ['required', 'integer'],
            'status' => ['required', 'boolean'],
            'addresses.*.address_1' => ['required', 'min:3', 'max:128'],
            'addresses.*.city' => ['required', 'min:2', 'max:128'],
            'addresses.*.state' => ['max:128'],
            'addresses.*.country_id' => ['required', 'integer'],
        ];

        if (!optional($this->getModel())->exists || $this->inputWith('password')) {
            $rules['password'] = ['required_if:send_invite,0', 'min:8', 'max:40', 'same:_confirm_password'];
        }

        return $rules;
    }

    protected function useDataFrom()
    {
        return static::DATA_TYPE_POST;
    }
}
