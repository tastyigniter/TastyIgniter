<?php

declare(strict_types=1);

namespace Igniter\Api\Tests\ApiResources\Requests;

use Igniter\Api\ApiResources\Requests\OrderRequest;

it('returns correct attribute labels', function(): void {
    $request = new OrderRequest;

    $attributes = $request->attributes();

    expect($attributes)->toHaveKey('first_name', lang('igniter.cart::default.checkout.label_first_name'))
        ->and($attributes)->toHaveKey('last_name', lang('igniter.cart::default.checkout.label_last_name'))
        ->and($attributes)->toHaveKey('email', lang('igniter.cart::default.checkout.label_email'))
        ->and($attributes)->toHaveKey('telephone', lang('igniter.cart::default.checkout.label_telephone'))
        ->and($attributes)->toHaveKey('comment', lang('igniter.cart::default.checkout.label_comment'))
        ->and($attributes)->toHaveKey('payment', lang('igniter.cart::default.checkout.label_payment_method'))
        ->and($attributes)->toHaveKey('order_type', lang('igniter.cart::default.checkout.label_order_type'))
        ->and($attributes)->toHaveKey('address_id', lang('igniter.cart::default.checkout.label_address'))
        ->and($attributes)->toHaveKey('address.address_1', lang('igniter.cart::default.checkout.label_address_1'))
        ->and($attributes)->toHaveKey('address.address_2', lang('igniter.cart::default.checkout.label_address_2'))
        ->and($attributes)->toHaveKey('address.city', lang('igniter.cart::default.checkout.label_city'))
        ->and($attributes)->toHaveKey('address.state', lang('igniter.cart::default.checkout.label_state'))
        ->and($attributes)->toHaveKey('address.postcode', lang('igniter.cart::default.checkout.label_postcode'))
        ->and($attributes)->toHaveKey('address.country_id', lang('igniter.cart::default.checkout.label_country'));
});

it('returns correct validation rules', function(): void {
    $request = new OrderRequest;
    $request->setMethod('POST');
    $request->merge([
        'order_type' => 'delivery',
    ]);

    $rules = $request->rules();

    expect($rules)->toHaveKey('first_name')
        ->and($rules)->toHaveKey('last_name')
        ->and($rules)->toHaveKey('email')
        ->and($rules)->toHaveKey('telephone')
        ->and($rules)->toHaveKey('comment')
        ->and($rules)->toHaveKey('payment')
        ->and($rules)->toHaveKey('order_type')
        ->and($rules)->toHaveKey('address_id')
        ->and($rules)->toHaveKey('address.address_1')
        ->and($rules)->toHaveKey('address.address_2')
        ->and($rules)->toHaveKey('address.city')
        ->and($rules)->toHaveKey('address.state')
        ->and($rules)->toHaveKey('address.postcode')
        ->and($rules)->toHaveKey('address.country_id')
        ->and($rules)->toHaveKey('customer_id')
        ->and($rules)->toHaveKey('order_menus')
        ->and($rules)->toHaveKey('order_totals')
        ->and($rules)->toHaveKey('status_id')
        ->and($rules)->toHaveKey('is_processed')
        ->and($rules['first_name'])->toContain('required', 'between:1,48')
        ->and($rules['last_name'])->toContain('required', 'between:1,48')
        ->and($rules['email'])->toContain('sometimes', 'required', 'email:filter', 'max:96')
        ->and($rules['telephone'])->toContain('string')
        ->and($rules['comment'])->toContain('max:500')
        ->and($rules['order_type'])->toContain('required', 'alpha_dash')
        ->and($rules['payment'])->toContain('sometimes', 'required', 'alpha_dash')
        ->and($rules['customer_id'])->toContain('integer')
        ->and($rules['order_menus'])->toContain('array')
        ->and($rules['order_totals'])->toContain('array')
        ->and($rules['status_id'])->toContain('integer')
        ->and($rules['is_processed'])->toContain('integer');
});
