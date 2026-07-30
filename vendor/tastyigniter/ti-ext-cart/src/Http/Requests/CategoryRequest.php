<?php

declare(strict_types=1);

namespace Igniter\Cart\Http\Requests;

use Igniter\System\Classes\FormRequest;
use Override;

class CategoryRequest extends FormRequest
{
    #[Override]
    public function attributes(): array
    {
        return [
            'name' => lang('igniter::admin.label_name'),
            'description' => lang('igniter::admin.label_description'),
            'permalink_slug' => lang('igniter.cart::default.categories.label_permalink_slug'),
            'parent_id' => lang('igniter.cart::default.categories.label_parent'),
            'priority' => lang('igniter.cart::default.categories.label_priority'),
            'status' => lang('igniter::admin.label_status'),
            'locations.*' => lang('igniter::admin.column_location'),
        ];
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'between:2,255'],
            'description' => ['string', 'min:2'],
            'permalink_slug' => ['nullable', 'alpha_dash', 'max:255'],
            'parent_id' => ['nullable', 'integer'],
            'priority' => ['nullable', 'integer'],
            'status' => ['boolean'],
            'locations' => ['nullable', 'array'],
            'locations.*' => ['integer'],
        ];
    }
}
