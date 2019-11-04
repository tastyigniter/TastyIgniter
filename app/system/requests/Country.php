<?php

namespace System\Requests;

use System\Classes\FormRequest;

class Country extends FormRequest
{
    public function rules()
    {
        return [
            ['country_name', 'admin::lang.label_name', 'required|between:2,128'],
            ['priority', 'system::lang.countries.label_priority', 'required|integer'],
            ['iso_code_2', 'system::lang.countries.label_iso_code2', 'required|string|size:2'],
            ['iso_code_3', 'system::lang.countries.label_iso_code3', 'required|string|size:3'],
            ['format', 'system::lang.countries.label_format', 'min:2'],
            ['status', 'admin::lang.label_status', 'required|integer'],
        ];
    }
}