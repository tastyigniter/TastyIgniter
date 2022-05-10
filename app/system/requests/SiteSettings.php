<?php

namespace System\Requests;

use System\Classes\FormRequest;

class SiteSettings extends FormRequest
{
    public function attributes()
    {
        return [
            'timezone' => lang('system::lang.settings.label_timezone'),
            'default_currency_code' => lang('system::lang.settings.label_site_currency'),
            'detect_language' => lang('system::lang.settings.label_detect_language'),
            'default_language' => lang('system::lang.settings.label_site_language'),
            'country_id' => lang('system::lang.settings.label_country'),
        ];
    }

    public function rules()
    {
        return [
            'timezone' => ['required', 'timezone'],
            'default_currency_code' => ['required', 'string'],
            'detect_language' => ['required', 'boolean'],
            'default_language' => ['required', 'string'],
            'country_id' => ['required', 'integer'],
        ];
    }

    protected function useDataFrom()
    {
        return static::DATA_TYPE_POST;
    }
}
