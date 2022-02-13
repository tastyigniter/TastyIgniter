<?php

namespace System\Requests;

use System\Classes\FormRequest;

class GeneralSettings extends FormRequest
{
    public function attributes()
    {
        return [
            'site_name' => lang('system::lang.settings.label_site_name'),
            'site_email' => lang('system::lang.settings.label_site_email'),
            'site_logo' => lang('system::lang.settings.label_site_logo'),
            'timezone' => lang('system::lang.settings.label_timezone'),
            'default_currency_code' => lang('system::lang.settings.label_site_currency'),
            'detect_language' => lang('system::lang.settings.label_detect_language'),
            'default_language' => lang('system::lang.settings.label_site_language'),
            'country_id' => lang('system::lang.settings.label_country'),
            'maps_api_key' => lang('system::lang.settings.label_maps_api_key'),
            'distance_unit' => lang('system::lang.settings.label_distance_unit'),
        ];
    }

    public function rules()
    {
        return [
            'site_name' => ['required', 'min:2', 'max:128'],
            'site_email' => ['required', 'email:filter', 'max:96'],
            'site_logo' => ['required'],
            'timezone' => ['required'],
            'default_currency_code' => ['required'],
            'detect_language' => ['required', 'integer'],
            'default_language' => ['required'],
            'country_id' => ['required', 'integer'],
        ];
    }

    protected function useDataFrom()
    {
        return static::DATA_TYPE_POST;
    }
}
