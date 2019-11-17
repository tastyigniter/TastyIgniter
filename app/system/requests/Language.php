<?php

namespace System\Requests;

use System\Classes\FormRequest;

class Language extends FormRequest
{
    protected function useDataFrom()
    {
        return static::DATA_TYPE_POST;
    }

    public function rules()
    {
        return [
            ['name', 'admin::lang.label_name', 'required|between:2,32'],
            ['code', 'system::lang.languages.label_code', 'required|regex:/^[a-zA-Z_]+$/'],
            ['status', 'admin::lang.label_status', 'required|boolean'],
            ['translations.*.source', 'system::lang.column_source', 'string|max:2500'],
            ['translations.*.translation', 'system::lang.column_translation', 'string|max:2500'],
        ];
    }
}