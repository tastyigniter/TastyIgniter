<?php

namespace Admin\Requests;

use System\Classes\FormRequest;

class Customer extends FormRequest
{
    protected function useDataFrom()
    {
        return static::DATA_TYPE_POST;
    }

    public function rules()
    {
        $rules = [
            ['first_name', 'admin::lang.customers.label_first_name', 'required|between:1,48'],
            ['last_name', 'admin::lang.customers.label_last_name', 'required|between:1,48'],
            ['email', 'admin::lang.label_email', 'required|email:filter|max:96|unique:customers,email'],
            ['telephone', 'admin::lang.customers.label_telephone', 'sometimes'],
            ['newsletter', 'admin::lang.customers.label_newsletter', 'sometimes|required|boolean'],
            ['customer_group_id', 'admin::lang.customers.label_customer_group', 'required|integer'],
            ['status', 'admin::lang.label_status', 'required|boolean'],
            ['addresses.*.address_1', 'admin::lang.customers.label_address_1', 'required|min:3|max:128'],
            ['addresses.*.city', 'admin::lang.customers.label_city', 'required|min:2|max:128'],
            ['addresses.*.state', 'admin::lang.customers.label_state', 'max:128'],
            ['addresses.*.postcode', 'admin::lang.customers.label_postcode'],
            ['addresses.*.country_id', 'admin::lang.customers.label_country', 'required|integer'],
        ];

        if (!$this->getModel()->exists OR $this->inputWith('password')) {
            $rules[] = ['password', 'lang:admin::lang.customers.label_password', 'required|min:8|max:40|same:_confirm_password'];
            $rules[] = ['_confirm_password', 'lang:admin::lang.customers.label_confirm_password'];
        }

        return $rules;
    }
}