<?php

namespace Admin\Requests;

use System\Classes\FormRequest;

class Coupon extends FormRequest
{
    public function rules()
    {
        return [
            ['name', 'admin::lang.label_name', 'required|between:2,128'],
            ['code', 'admin::lang.coupons.label_code', 'required|min:2|unique:coupons,code'],
            ['type', 'admin::lang.label_type', 'required|string|size:1'],
            ['discount', 'admin::lang.coupons.label_discount', 'required|numeric|max:100'],
            ['min_total', 'admin::lang.coupons.label_min_total', 'numeric'],
            ['redemptions', 'admin::lang.coupons.label_redemption', 'required|integer'],
            ['customer_redemptions', 'admin::lang.coupons.label_customer_redemption', 'required|integer'],
            ['description', 'admin::lang.label_description', 'max:1028'],
            ['validity', 'admin::lang.coupons.label_validity', 'required|in:forever,fixed,period,recurring'],
            ['fixed_date', 'admin::lang.coupons.label_fixed_date', 'nullable|required_if:validity,fixed|date'],
            ['fixed_from_time', 'admin::lang.coupons.label_fixed_from_time', 'nullable|required_if:validity,fixed|valid_time'],
            ['fixed_to_time', 'admin::lang.coupons.label_fixed_to_time', 'nullable|required_if:validity,fixed|valid_time'],
            ['period_start_date', 'admin::lang.coupons.label_period_start_date', 'nullable|required_if:validity,period|date'],
            ['period_end_date', 'admin::lang.coupons.label_period_end_date', 'nullable|required_if:validity,period|date'],
            ['recurring_every', 'admin::lang.coupons.label_recurring_every', 'nullable|required_if:validity,recurring'],
            ['recurring_from_time', 'admin::lang.coupons.label_recurring_from_time', 'nullable|required_if:validity,recurring|valid_time'],
            ['recurring_to_time', 'admin::lang.coupons.label_recurring_to_time', 'nullable|required_if:validity,recurring|valid_time'],
            ['order_restriction', 'admin::lang.coupons.label_order_restriction', 'integer'],
            ['status', 'admin::lang.label_status', 'boolean'],
            ['locations.*', 'admin::lang.column_location', 'integer'],
        ];
    }

    protected function prepareMaxRule($parameters, $field)
    {
        if ($field === 'discount' AND $this->inputWith('type') != 'P') {
            return '';
        }

        return 'max:'.implode(',', $parameters);
    }
}