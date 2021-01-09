<?php

namespace Admin\Requests;

use System\Classes\FormRequest;

class Menu extends FormRequest
{
    public function rules()
    {
        return [
            ['menu_name', 'admin::lang.label_name', 'required|between:2,255'],
            ['menu_description', 'admin::lang.label_description', 'between:2,1028'],
            ['menu_price', 'admin::lang.menus.label_price', 'required|numeric|min:0'],
            ['categories.*', 'admin::lang.menus.label_category', 'sometimes|required|integer'],
            ['locations.*', 'admin::lang.column_location', 'sometimes|integer'],
            ['stock_qty', 'admin::lang.menus.label_stock_qty', 'nullable|integer'],
            ['minimum_qty', 'admin::lang.menus.label_minimum_qty', 'sometimes|required|integer|min:1'],
            ['subtract_stock', 'admin::lang.menus.label_subtract_stock', 'sometimes|required|boolean'],
            ['order_restriction', 'admin::lang.menus.label_order_restriction', 'nullable|integer'],
            ['menu_status', 'admin::lang.label_status', 'boolean'],
            ['menu_priority', 'admin::lang.menus.label_menu_priority', 'nullable|integer'],

            ['special.special_id', 'lang:admin::lang.column_id', 'integer'],
            ['special.type', 'lang:admin::lang.menus.label_special_type', 'alpha|in:F,P'],
            ['special.special_price', 'lang:admin::lang.menus.label_special_price', 'numeric'],
            ['special.validity', 'lang:admin::lang.menus.label_validity', 'alpha|in:forever,period,recurring'],
            ['special.start_date', 'lang:admin::lang.menus.label_start_date', 'nullable|required_if:special.validity,period|date'],
            ['special.end_date', 'lang:admin::lang.menus.label_end_date', 'nullable|required_if:special.validity,period|date'],
            ['special.recurring_every', 'lang:admin::lang.menus.label_recurring_every', 'required_if:special.validity,recurring|alpha|max:3'],
            ['special.recurring_from', 'lang:admin::lang.menus.label_recurring_from_time', 'nullable|required_if:special.validity,recurring|valid_time'],
            ['special.recurring_to', 'lang:admin::lang.menus.label_recurring_to_time', 'nullable|required_if:special.validity,recurring|valid_time'],
        ];
    }
}
