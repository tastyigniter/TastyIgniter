<?php

declare(strict_types=1);

namespace Igniter\Api\ApiResources\Requests;

use Igniter\System\Classes\FormRequest;
use Override;

class AddressRequest extends FormRequest
{
    #[Override]
    public function attributes(): array
    {
        return [
            'address_1' => lang('igniter.cart::default.checkout.label_address_1'),
            'address_2' => lang('igniter.cart::default.checkout.label_address_2'),
            'city' => lang('igniter.cart::default.checkout.label_city'),
            'state' => lang('igniter.cart::default.checkout.label_state'),
            'postcode' => lang('igniter.cart::default.checkout.label_postcode'),
            'country_id' => lang('igniter.cart::default.checkout.label_country'),
            'customer_id' => lang('igniter.api::default.addresses.label_customer_id'),
        ];
    }

    public function rules(): array
    {
        return [
            'address_1' => ['required', 'min:3', 'max:128'],
            'address_2' => ['sometimes', 'nullable', 'min:1', 'max:128'],
            'city' => ['required', 'min:2', 'max:128'],
            'state' => ['sometimes', 'nullable', 'max:128'],
            'postcode' => ['sometimes', 'nullable', 'string', 'max:128'],
            'country_id' => ['required', 'integer'],
            'customer_id' => ['integer'],
        ];
    }
}
