<?php

declare(strict_types=1);

namespace Igniter\Cart\Http\Requests;

use Igniter\System\Classes\FormRequest;
use Override;

class MenuOptionRequest extends FormRequest
{
    #[Override]
    public function attributes(): array
    {
        return [
            'option_name' => lang('igniter.cart::default.menu_options.label_option_group_name'),
            'display_type' => lang('igniter.cart::default.menu_options.label_display_type'),
            'is_required' => lang('igniter.cart::default.menu_options.label_option_required'),
            'min_selected' => lang('igniter.cart::default.menu_options.label_min_selected'),
            'max_selected' => lang('igniter.cart::default.menu_options.label_max_selected'),
            'locations.*' => lang('igniter::admin.label_location'),
            'values' => lang('igniter.cart::default.menu_options.label_option_values'),
        ];
    }

    public function rules(): array
    {
        return [
            'option_name' => ['required', 'string', 'min:2', 'max:32'],
            'display_type' => ['required', 'alpha'],
            'is_required' => ['boolean'],
            'min_selected' => ['integer', 'lte:max_selected'],
            'max_selected' => ['integer', 'gte:min_selected'],
            'locations' => ['nullable', 'array'],
            'locations.*' => ['integer'],
            'values' => ['required', 'array'],
        ];
    }
}
