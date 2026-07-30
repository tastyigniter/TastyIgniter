<?php

declare(strict_types=1);

namespace Igniter\User\Tests\Models;

use Igniter\System\Models\Concerns\HasCountry;
use Igniter\System\Models\Country;
use Igniter\User\Models\Address;
use Igniter\User\Models\Concerns\HasCustomer;
use Igniter\User\Models\Customer;
use Mockery;

it('creates or updates address from request', function(): void {
    $addressData = [
        'customer_id' => fake()->randomDigit(),
        'address_id' => fake()->randomDigit(),
        'address_1' => '123 Main St',
        'address_2' => 'Apt 4',
        'city' => 'Anytown',
        'state' => 'CA',
        'postcode' => '12345',
        'country_id' => 1,
    ];

    $address = Address::createOrUpdateFromRequest($addressData);

    expect($address->wasRecentlyCreated)->toBeTrue()
        ->and($address->address_1)->toBe('123 Main St');

    $address = Address::factory()->create(['customer_id' => $addressData['customer_id']]);
    $updatedData = array_merge($addressData, ['address_id' => $address->getKey(), 'city' => 'New City']);

    $updatedAddress = Address::createOrUpdateFromRequest($updatedData);

    expect($updatedAddress->wasRecentlyCreated)->toBeFalse()
        ->and($updatedAddress->city)->toBe('New City');
});

it('creates new address from request when address_id is missing', function(): void {
    $addressData = [
        'customer_id' => 1,
        'address_1' => '456 Elm St',
        'address_2' => 'Suite 5',
        'city' => 'Othertown',
        'state' => 'NY',
        'postcode' => '67890',
        'country_id' => 1,
    ];

    $address = Address::createOrUpdateFromRequest($addressData);

    expect($address->wasRecentlyCreated)->toBeTrue();
});

it('returns formatted address attribute', function(): void {
    $expectedAddress = '123 Main St, Apt 4, Anytown 12345, CA, Afghanistan';
    $address = Mockery::mock(Address::class)->makePartial();
    $address->shouldReceive('toArray')->andReturn([
        'address_1' => '123 Main St',
        'address_2' => 'Apt 4',
        'city' => 'Anytown',
        'state' => 'CA',
        'postcode' => '12345',
        'country_id' => 1,
    ]);
    $address->shouldReceive('format_address')->with(Mockery::type('array'), false)->andReturn($expectedAddress);

    $result = $address->getFormattedAddressAttribute(null);

    expect($result)->toBe($expectedAddress);
});

it('applies filters to query builder', function(): void {
    $query = Address::query()->applyFilters([
        'customer' => 1,
        'sort' => 'address_id desc',
    ]);

    expect($query->toSql())->toContain('where `addresses`.`customer_id` = ?')
        ->and($query->toSql())->toContain('order by `address_id` desc');
});

it('configures address model correctly', function(): void {
    $address = new Address;

    expect(class_uses_recursive($address))
        ->toContain(HasCountry::class)
        ->toContain(HasCustomer::class)
        ->and($address->getTable())->toBe('addresses')
        ->and($address->getKeyName())->toBe('address_id')
        ->and($address->getFillable())->toBe(['customer_id', 'address_1', 'address_2', 'city', 'state', 'postcode', 'country_id'])
        ->and($address->getCasts()['customer_id'])->toBe('integer')
        ->and($address->getCasts()['country_id'])->toBe('integer')
        ->and($address->getMorphClass())->toBe('addresses')
        ->and($address->relation['belongsTo']['customer'])->toBe(Customer::class)
        ->and($address->relation['belongsTo']['country'])->toBe(Country::class);
});
