<?php

namespace System\Requests;

use System\Classes\FormRequest;

class Language extends FormRequest
{
    public function attributes()
    {
        return [
            'name' => lang('admin::lang.label_name'),
            'code' => lang('system::lang.languages.label_code'),
            'status' => lang('admin::lang.label_status'),
            'translations.*.source' => lang('system::lang.column_source'),
            'translations.*.translation' => lang('system::lang.column_translation'),
        ];
    }

    public function rules()
    {
        return [
            'name' => ['required', 'between:2,32'],
            'code' => ['required', 'regex:/^[a-zA-Z_]+$/'],
            'status' => ['required', 'boolean'],
            'translations.*.source' => ['string', 'max:2500'],
            'translations.*.translation' => ['string', 'max:2500'],
        ];
    }

    protected function useDataFrom()
    {
        return static::DATA_TYPE_POST;
    }
}
