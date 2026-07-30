<?php

declare(strict_types=1);

namespace Igniter\Cart\Http\Requests;

use Igniter\System\Classes\FormRequest;
use Override;

class IngredientRequest extends FormRequest
{
    #[Override]
    public function attributes(): array
    {
        return [
            'name' => lang('igniter::admin.label_name'),
            'description' => lang('igniter::admin.label_description'),
            'status' => lang('igniter::admin.label_status'),
            'is_allergen' => lang('igniter.cart::default.ingredients.label_allergen'),
        ];
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'between:2,255'],
            'description' => ['string', 'min:2'],
            'status' => ['boolean'],
            'is_allergen' => ['boolean'],
        ];
    }
}
