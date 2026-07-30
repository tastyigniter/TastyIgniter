<?php

declare(strict_types=1);

namespace Igniter\Api\ApiResources\Requests;

use Igniter\System\Classes\FormRequest;
use Override;

class OrderRequest extends FormRequest
{
    #[Override]
    public function attributes(): array
    {
        return [
            'first_name' => lang('igniter.cart::default.checkout.label_first_name'),
            'last_name' => lang('igniter.cart::default.checkout.label_last_name'),
            'email' => lang('igniter.cart::default.checkout.label_email'),
            'telephone' => lang('igniter.cart::default.checkout.label_telephone'),
            'comment' => lang('igniter.cart::default.checkout.label_comment'),
            'payment' => lang('igniter.cart::default.checkout.label_payment_method'),
            'order_type' => lang('igniter.cart::default.checkout.label_order_type'),
            'address_id' => lang('igniter.cart::default.checkout.label_address'),
            'address.address_1' => lang('igniter.cart::default.checkout.label_address_1'),
            'address.address_2' => lang('igniter.cart::default.checkout.label_address_2'),
            'address.city' => lang('igniter.cart::default.checkout.label_city'),
            'address.state' => lang('igniter.cart::default.checkout.label_state'),
            'address.postcode' => lang('igniter.cart::default.checkout.label_postcode'),
            'address.country_id' => lang('igniter.cart::default.checkout.label_country'),
            'customer_id' => lang('igniter.api::default.orders.label_customer_id'),
        ];
    }

    public function rules(): array
    {
        $rules = [
            'first_name' => ['between:1,48'],
            'last_name' => ['between:1,48'],
            'email' => ['sometimes', 'required', 'email:filter', 'max:96'],
            'telephone' => ['string'],
            'comment' => ['max:500'],
            'order_type' => ['alpha_dash'],
            'payment' => ['sometimes', 'required', 'alpha_dash'],
            'customer_id' => ['integer'],
            'order_menus' => ['array'],
            'order_totals' => ['array'],
            'status_id' => ['integer'],
            'is_processed' => ['integer'],
        ];

        if (strtolower($this->method()) === 'post') {
            $rules['first_name'][] = 'required';
            $rules['last_name'][] = 'required';
            $rules['order_type'][] = 'required';
        }

        if ($this->input('order_type', 'collection') == 'delivery') {
            $rules['address_id'] = ['integer'];
            $rules['address.address_1'] = ['required', 'min:3', 'max:128'];
            $rules['address.address_2'] = ['sometimes', 'min:3', 'max:128'];
            $rules['address.city'] = ['sometimes', 'min:2', 'max:128'];
            $rules['address.state'] = ['sometimes', 'max:128'];
            $rules['address.postcode'] = ['string'];
            $rules['address.country_id'] = ['sometimes', 'required', 'integer'];
        }

        return $rules;
    }

    #[Override]
    public function all($keys = null)
    {
        return array_except(parent::all($keys), ['order_menus', 'order_totals']);
    }
}
