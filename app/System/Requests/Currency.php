<?php

namespace System\Requests;

use System\Classes\FormRequest;

class Currency extends FormRequest
{
    public function attributes()
    {
        return [
            'currency_name' => lang('system::lang.currencies.label_title'),
            'currency_code' => lang('system::lang.currencies.label_code'),
            'currency_symbol' => lang('system::lang.currencies.label_symbol'),
            'country_id' => lang('system::lang.currencies.label_country'),
            'symbol_position' => lang('system::lang.currencies.label_symbol_position'),
            'currency_rate' => lang('system::lang.currencies.label_rate'),
            'thousand_sign' => lang('system::lang.currencies.label_thousand_sign'),
            'decimal_sign' => lang('system::lang.currencies.label_decimal_sign'),
            'decimal_position' => lang('ystem::lang.currencies.label_decimal_position'),
            'currency_status' => lang('admin::lang.label_status'),
        ];
    }

    public function rules()
    {
        return [
            'currency_name' => ['required', 'between:2,32'],
            'currency_code' => ['required', 'string', 'size:3'],
            'currency_symbol' => ['string'],
            'country_id' => ['required', 'integer'],
            'symbol_position' => ['string', 'size:1'],
            'currency_rate' => ['numeric'],
            'thousand_sign' => ['string', 'size:1'],
            'decimal_sign' => ['size:1'],
            'decimal_position' => ['integer'],
            'currency_status' => ['required', 'boolean'],
        ];
    }
}
