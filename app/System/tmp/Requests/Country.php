<?php

namespace System\Requests;

use System\Classes\FormRequest;

class Country extends FormRequest
{
    public function attributes()
    {
        return [
            'country_name' => lang('admin::lang.label_name'),
            'priority' => lang('system::lang.countries.label_priority'),
            'iso_code_2' => lang('system::lang.countries.label_iso_code2'),
            'iso_code_3' => lang('system::lang.countries.label_iso_code3'),
            'format' => lang('system::lang.countries.label_format'),
            'status' => lang('admin::lang.label_status'),
        ];
    }

    public function rules()
    {
        return [
            'country_name' => ['required', 'between:2,128'],
            'priority' => ['required', 'integer'],
            'iso_code_2' => ['required', 'string', 'size:2'],
            'iso_code_3' => ['required', 'string', 'size:3'],
            'format' => ['min:2'],
            'status' => ['required', 'boolean'],
        ];
    }
}
