<?php

declare(strict_types=1);

namespace Igniter\Cart\Http\Requests;

use Igniter\System\Classes\FormRequest;
use Override;

class MenuRequest extends FormRequest
{
    #[Override]
    public function attributes(): array
    {
        return [
            'menu_name' => lang('igniter::admin.label_name'),
            'menu_description' => lang('igniter::admin.label_description'),
            'menu_price' => lang('igniter.cart::default.menus.label_price'),
            'categories.*' => lang('igniter.cart::default.menus.label_category'),
            'ingredients.*' => lang('igniter.cart::default.menus.label_ingredients'),
            'mealtimes.*' => lang('igniter.cart::default.menus.label_mealtime'),
            'locations.*' => lang('igniter::admin.column_location'),
            'minimum_qty' => lang('igniter.cart::default.menus.label_minimum_qty'),
            'order_restriction.*' => lang('igniter.cart::default.menus.label_order_restriction'),
            'menu_status' => lang('igniter::admin.label_status'),
            'mealtime_id' => lang('igniter.cart::default.menus.label_mealtime'),
            'menu_priority' => lang('igniter.cart::default.menus.label_menu_priority'),
            'menu_option_values' => lang('igniter.cart::default.menu_options.label_option_value_id'),
        ];
    }

    public function rules(): array
    {
        return [
            'menu_name' => ['required', 'string', 'between:2,255'],
            'menu_description' => ['nullable', 'string', 'between:2,1028'],
            'menu_price' => ['required', 'numeric', 'min:0'],
            'categories' => ['nullable', 'array'],
            'categories.*' => ['sometimes', 'required', 'integer'],
            'ingredients' => ['nullable', 'array'],
            'ingredients.*' => ['sometimes', 'required', 'integer'],
            'mealtimes' => ['nullable', 'array'],
            'mealtimes.*' => ['sometimes', 'required', 'integer'],
            'locations' => ['nullable', 'array'],
            'locations.*' => ['integer'],
            'minimum_qty' => ['sometimes', 'required', 'integer', 'min:1'],
            'order_restriction.*' => ['nullable', 'string'],
            'menu_status' => ['boolean'],
            'mealtime_id' => ['nullable', 'integer'],
            'menu_priority' => ['min:0', 'integer'],
            'menu_options' => ['nullable', 'array'],
            'menu_options.*.menu_option_id' => ['required', 'integer'],
            'menu_options.*.priority' => ['integer'],
            'special.special_id' => ['nullable', 'integer'],
            'special.type' => ['string', 'in:F,P'],
            'special.special_price' => ['nullable', 'numeric', 'min:0'],
            'special.validity' => ['string', 'in:forever,period,recurring'],
            'special.start_date' => ['required_if:special.validity,period', 'nullable', 'date'],
            'special.end_date' => ['required_if:special.validity,period', 'nullable', 'date'],
            'special.recurring_every' => ['required_if:special.validity,recurring', 'nullable', 'array'],
            'special.recurring_every.*' => ['required_if:special.validity,recurring', 'integer'],
            'special.recurring_from' => ['required_if:special.validity,recurring', 'nullable', 'date_format:H:i'],
            'special.recurring_to' => ['required_if:special.validity,recurring', 'nullable', 'date_format:H:i'],
            'special.special_status' => ['boolean'],
        ];
    }
}
