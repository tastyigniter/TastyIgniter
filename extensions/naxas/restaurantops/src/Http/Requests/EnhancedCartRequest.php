<?php

declare(strict_types=1);

namespace Naxas\RestaurantOps\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;
use Naxas\RestaurantOps\Contracts\AuditLogger;
use Naxas\RestaurantOps\MenuConfiguration\Support\Context;

final class EnhancedCartRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'contract_version' => ['required', Rule::in(['1.0'])],
            'menu_id' => ['required', 'integer', 'min:1'],
            'location_id' => ['required', 'integer', 'min:1'],
            'location_mode' => ['sometimes', Rule::notIn(['global'])],
            'service_type' => ['required', Rule::in(Context::SERVICE_TYPES)],
            'channel' => ['required', Rule::in(['storefront'])],
            'quantity' => ['required', 'integer', 'between:1,99'],
            'variant_id' => ['nullable', 'integer', 'min:1'],
            'modifier_selections' => ['present', 'array', 'max:50'],
            'modifier_selections.*.group_id' => ['required', 'integer', 'min:1'],
            'modifier_selections.*.modifiers' => ['present', 'array', 'max:50'],
            'modifier_selections.*.modifiers.*.modifier_id' => ['required', 'integer', 'min:1'],
            'modifier_selections.*.modifiers.*.quantity' => ['required', 'integer', 'between:1,99'],
            'combo_selections' => ['present', 'array', 'max:25'],
            'combo_selections.*.group_id' => ['required', 'integer', 'min:1'],
            'combo_selections.*.choices' => ['present', 'array', 'max:25'],
            'combo_selections.*.choices.*.choice_id' => ['required', 'integer', 'min:1'],
            'combo_selections.*.choices.*.quantity' => ['required', 'integer', 'between:1,99'],
            'item_note' => ['nullable', 'string', 'max:500'],
            'configuration_hash' => ['nullable', 'string', 'size:64', 'regex:/^[a-f0-9]{64}$/'],
            'unit_price' => ['prohibited'], 'price' => ['prohibited'], 'subtotal' => ['prohibited'],
            'total' => ['prohibited'], 'modifier_price' => ['prohibited'], 'discount' => ['prohibited'],
        ];
    }

    protected function failedValidation(Validator $validator): void
    {
        app(AuditLogger::class)->warning('restaurantops.request_validation_failed', array_filter([
            'menu_id' => $this->input('menu_id'), 'location_id' => $this->input('location_id'),
            'service_type' => $this->input('service_type'), 'channel' => $this->input('channel'),
            'fields' => array_keys($validator->errors()->toArray()),
        ]));
        throw new HttpResponseException(response()->json([
            'error' => ['code' => 'restaurantops_selection_invalid', 'message' => 'The enhanced selection request is invalid.', 'details' => $validator->errors()],
        ], 422));
    }
}
