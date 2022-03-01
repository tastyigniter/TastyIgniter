<?php

namespace Admin\Requests;

use System\Classes\FormRequest;

class Menu extends FormRequest
{
    public function attributes()
    {
        return [
            'menu_name' => lang('admin::lang.label_name'),
            'menu_description' => lang('admin::lang.label_description'),
            'menu_price' => lang('admin::lang.menus.label_price'),
            'categories.*' => lang('admin::lang.menus.label_category'),
            'locations.*' => lang('admin::lang.column_location'),
            'minimum_qty' => lang('admin::lang.menus.label_minimum_qty'),
            'order_restriction.*' => lang('admin::lang.menus.label_order_restriction'),
            'menu_status' => lang('admin::lang.label_status'),
            'mealtime_id' => lang('admin::lang.menus.label_mealtime'),
            'menu_priority' => lang('admin::lang.menus.label_menu_priority'),
            'menu_option_values' => lang('admin::lang.menu_options.label_option_value_id'),
        ];
    }

    public function rules()
    {
        return [
            'menu_name' => ['required', 'string', 'between:2,255'],
            'menu_description' => ['string', 'between:2,1028'],
            'menu_price' => ['required', 'numeric', 'min:0'],
            'categories.*' => ['sometimes', 'required', 'integer'],
            'locations.*' => ['integer'],
            'minimum_qty' => ['sometimes', 'required', 'integer', 'min:1'],
            'order_restriction' => ['array'],
            'order_restriction.*' => ['nullable', 'string'],
            'menu_status' => ['boolean'],
            'mealtime_id' => ['nullable', 'integer'],
            'menu_priority' => ['nullable', 'integer'],
        ];
    }
}
