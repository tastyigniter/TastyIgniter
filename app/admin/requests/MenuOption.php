<?php

namespace Admin\Requests;

use System\Classes\FormRequest;

class MenuOption extends FormRequest
{
    public function attributes()
    {
        return [
            'option_name' => lang('admin::lang.menu_options.label_option_name'),
            'display_type' => lang('admin::lang.menu_options.label_display_type'),
            'is_required' => lang('admin::lang.menu_options.label_option_required'),
            'min_selected' => lang('admin::lang.menu_options.label_min_selected'),
            'max_selected' => lang('admin::lang.menu_options.label_max_selected'),
            'locations.*' => lang('admin::lang.label_location'),
            'option_values' => lang('admin::lang.menu_options.label_option_values'),
        ];
    }

    public function rules()
    {
        return [
            'option_name' => ['required', 'string', 'min:2', 'max:32'],
            'display_type' => ['required', 'alpha'],
            'is_required' => ['boolean'],
            'min_selected' => ['integer', 'lte:max_selected'],
            'max_selected' => ['integer', 'gte:min_selected'],
            'locations' => ['array'],
            'locations.*' => ['integer'],
            'option_values' => ['required', 'array'],
        ];
    }
}
