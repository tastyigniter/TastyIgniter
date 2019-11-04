<?php

namespace System\Requests;

use System\Classes\FormRequest;

class Currency extends FormRequest
{
    public function rules()
    {
        return [
            ['currency_name', 'system::lang.currencies.label_title', 'required|between:2,32'],
            ['currency_code', 'system::lang.currencies.label_code', 'required|string|size:3'],
            ['currency_symbol', 'system::lang.currencies.label_symbol', 'required|string'],
            ['country_id', 'system::lang.currencies.label_country', 'required|integer'],
            ['symbol_position', 'system::lang.currencies.label_symbol_position', 'required|string|size:1'],
            ['currency_rate', 'system::lang.currencies.label_rate', 'required|numeric'],
            ['thousand_sign', 'system::lang.currencies.label_thousand_sign', 'required|string|size:1'],
            ['decimal_sign', 'system::lang.currencies.label_decimal_sign', 'required|size:1'],
            ['decimal_position', 'system::lang.currencies.label_decimal_position', 'required|string|size:1'],
            ['currency_status', 'admin::lang.label_status', 'required|integer'],
        ];
    }
}