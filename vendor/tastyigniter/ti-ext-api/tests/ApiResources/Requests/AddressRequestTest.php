<?php

declare(strict_types=1);

namespace Igniter\Api\Tests\ApiResources\Requests;

use Igniter\Api\ApiResources\Requests\AddressRequest;

it('returns correct attribute labels', function(): void {
    $request = new AddressRequest;

    $attributes = $request->attributes();

    expect($attributes)->toHaveKey('address_1', lang('igniter.cart::default.checkout.label_address_1'))
        ->and($attributes)->toHaveKey('address_2', lang('igniter.cart::default.checkout.label_address_2'))
        ->and($attributes)->toHaveKey('city', lang('igniter.cart::default.checkout.label_city'))
        ->and($attributes)->toHaveKey('state', lang('igniter.cart::default.checkout.label_state'))
        ->and($attributes)->toHaveKey('postcode', lang('igniter.cart::default.checkout.label_postcode'))
        ->and($attributes)->toHaveKey('country_id', lang('igniter.cart::default.checkout.label_country'))
        ->and($attributes)->toHaveKey('customer_id', lang('igniter.api::default.addresses.label_customer_id'));
});

it('returns correct validation rules', function(): void {
    $request = new AddressRequest;

    $rules = $request->rules();

    expect($rules)->toHaveKey('address_1')
        ->and($rules)->toHaveKey('address_2')
        ->and($rules)->toHaveKey('city')
        ->and($rules)->toHaveKey('state')
        ->and($rules)->toHaveKey('postcode')
        ->and($rules)->toHaveKey('country_id')
        ->and($rules)->toHaveKey('customer_id')
        ->and($rules['address_1'])->toContain('required', 'min:3', 'max:128')
        ->and($rules['city'])->toContain('required', 'min:2', 'max:128')
        ->and($rules['country_id'])->toContain('required', 'integer')
        ->and($rules['customer_id'])->toContain('integer');
});
