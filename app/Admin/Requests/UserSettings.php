<?php

namespace Admin\Requests;

use System\Classes\FormRequest;

class UserSettings extends FormRequest
{
    public function attributes()
    {
        return [
            'allow_registration' => lang('system::lang.settings.label_allow_registration'),
            'registration_email.*' => lang('system::lang.settings.label_registration_email'),
        ];
    }

    public function rules()
    {
        return [
            'allow_registration' => ['required', 'integer'],
            'registration_email.*' => ['required', 'alpha'],
        ];
    }
}
