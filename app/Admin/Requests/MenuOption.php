<?php

namespace Admin\Requests;

use System\Classes\FormRequest;

class MenuOption extends FormRequest
{
    public function rules()
    {
        return [
            ['option_name', 'lang:admin::lang.menu_options.label_option_name', 'required|min:2|max:32'],
            ['display_type', 'lang:admin::lang.menu_options.label_display_type', 'required|alpha'],
            ['is_required', 'admin::lang.menu_options.label_option_required', 'boolean'],
            ['min_selected', 'admin::lang.menu_options.label_min_selected', 'integer|lte:max_selected'],
            ['max_selected', 'admin::lang.menu_options.label_max_selected', 'integer|gte:min_selected'],
            ['locations.*', 'lang:admin::lang.label_location', 'integer'],
            ['option_values', 'lang:admin::lang.menu_options.label_option_values', 'required'],
        ];
    }
}
