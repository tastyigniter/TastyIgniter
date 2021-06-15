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
            ['locations.*', 'admin::lang.column_location', 'integer'],
            ['stock_qty', 'admin::lang.menus.label_stock_qty', 'nullable|integer'],
            ['minimum_qty', 'admin::lang.menus.label_minimum_qty', 'sometimes|required|integer|min:1'],
            ['subtract_stock', 'admin::lang.menus.label_subtract_stock', 'sometimes|required|boolean'],
            ['order_restriction.*', 'admin::lang.menus.label_order_restriction', 'nullable|string'],
            ['menu_status', 'admin::lang.label_status', 'boolean'],
            ['mealtime_id', 'admin::lang.menus.label_mealtime', 'nullable|integer'],
            ['menu_priority', 'admin::lang.menus.label_menu_priority', 'nullable|integer'],
        ];
    }
}
