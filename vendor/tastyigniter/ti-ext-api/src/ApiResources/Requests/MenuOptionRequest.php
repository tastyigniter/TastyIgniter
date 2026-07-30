<?php

declare(strict_types=1);

namespace Igniter\Api\ApiResources\Requests;

use Igniter\System\Classes\FormRequest;
use Override;

class MenuOptionRequest extends FormRequest
{
    #[Override]
    public function attributes(): array
    {
        return [
            'option_name' => lang('admin::lang.menu_options.label_option_group_name'),
            'display_type' => lang('admin::lang.menu_options.label_display_type'),
            'priority' => lang('admin::lang.menu_options.label_priority'),
            'locations.*' => lang('admin::lang.label_location'),
            'option_values.*.option_value_id' => lang('admin::lang.label_option_value_id'),
            'option_values.*.option_id' => lang('admin::lang.label_option_id'),
            'option_values.*.value' => lang('admin::lang.menu_options.label_option_value'),
            'option_values.*.price' => lang('admin::lang.menu_options.label_option_price'),
            'option_values.*.priority' => lang('admin::lang.menu_options.label_option_price'),
            'option_values.*.allergens.*' => lang('igniter.cart::default.menus.label_allergens'),
        ];
    }

    public function rules(): array
    {
        return [
            'option_name' => ['required', 'min:2', 'max:32'],
            'display_type' => ['required', 'alpha'],
            'priority' => ['integer'],
            'locations.*' => ['integer'],
            'option_values.*.option_value_id' => ['integer'],
            'option_values.*.option_id' => ['integer'],
            'option_values.*.value' => ['min:2', 'max:128'],
            'option_values.*.price' => ['numeric', 'min:0'],
            'option_values.*.priority' => ['integer'],
            'option_values.*.allergens.*' => ['integer'],
        ];
    }
}
