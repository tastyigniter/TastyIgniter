<?php

declare(strict_types=1);

namespace Igniter\Api\Tests\ApiResources;

use Igniter\System\Models\Country;
use Igniter\User\Models\Address;
use Igniter\User\Models\Customer;
use Igniter\User\Models\User;
use Laravel\Sanctum\Sanctum;

it('returns all addresses', function(): void {
    Sanctum::actingAs(User::factory()->create(), ['addresses:*']);
    $customer = Customer::factory()->create();
    Address::factory()->count(3)->create(['customer_id' => $customer->getKey()]);
    $address = Address::first();

    $this
        ->get(route('igniter.api.addresses.index'))
        ->assertOk()
        ->assertJsonPath('data.0.id', (string)$address->getKey())
        ->assertJsonPath('data.0.attributes.address_1', $address->address_1)
        ->assertJsonCount(3, 'data');
});

it('returns only authenticated customer addresses', function(): void {
    $customer = Customer::factory()->create();
    $customer->addresses()->create([
        'address_1' => '123 Own St',
        'city' => 'London',
        'country_id' => 1,
    ]);
    Customer::factory()->create()->addresses()->create([
        'address_1' => '456 Other St',
        'city' => 'Paris',
        'country_id' => 1,
    ]);
    Sanctum::actingAs($customer, ['addresses:*']);

    $this
        ->get(route('igniter.api.addresses.index'))
        ->assertOk()
        ->assertJsonPath('data.0.attributes.address_1', '123 Own St')
        ->assertJsonCount(1, 'data');
});

it('can not show another customer address', function(): void {
    $anotherCustomer = Customer::factory()->create();
    $otherAddress = $anotherCustomer->addresses()->create([
        'address_1' => '456 Other St',
        'city' => 'Paris',
        'country_id' => 1,
    ]);
    Sanctum::actingAs(Customer::factory()->create(), ['addresses:*']);

    $this
        ->get(route('igniter.api.addresses.show', [$otherAddress->getKey()]))
        ->assertStatus(404);
});

it('can not update customer aware column', function(): void {
    $customer = Customer::factory()->create();
    $address = $customer->addresses()->create([
        'address_1' => '123 Test St',
        'city' => 'London',
        'country_id' => 1,
    ]);
    Sanctum::actingAs($customer, ['addresses:*']);

    $this
        ->put(route('igniter.api.addresses.update', [$address->getKey()]), [
            'customer_id' => 9999,
            'address_1' => 'Updated St',
            'city' => 'London',
            'country_id' => 1,
        ])
        ->assertOk()
        ->assertJsonPath('data.attributes.address_1', 'Updated St')
        ->assertJsonPath('data.attributes.customer_id', $customer->getKey());
});

it('shows an address', function(): void {
    Sanctum::actingAs(User::factory()->create(), ['addresses:*']);
    $customer = Customer::factory()->create();
    $address = $customer->addresses()->create([
        'address_1' => '123 Test Address',
        'address_2' => 'Flat 1',
        'city' => 'London',
        'state' => 'Greater London',
        'postcode' => 'W1A 1AA',
        'country_id' => 1,
    ]);

    $this
        ->get(route('igniter.api.addresses.show', [$address->getKey()]))
        ->assertOk()
        ->assertJsonPath('data.id', (string)$address->getKey())
        ->assertJsonPath('data.attributes.address_1', '123 Test Address')
        ->assertJsonPath('data.attributes.address_2', 'Flat 1')
        ->assertJsonPath('data.attributes.city', 'London')
        ->assertJsonPath('data.attributes.country_id', 1);
});

it('shows an address with country relationship', function(): void {
    Sanctum::actingAs(User::factory()->create(), ['addresses:*']);
    $customer = Customer::factory()->create();
    $country = Country::factory()->create(['country_name' => 'United Kingdom', 'iso_code_2' => 'GB']);
    $address = $customer->addresses()->create([
        'address_1' => '123 Test Address',
        'city' => 'London',
        'country_id' => $country->getKey(),
    ]);

    $this
        ->get(route('igniter.api.addresses.show', [$address->getKey()]).'?'.http_build_query([
            'include' => 'country',
        ]))
        ->assertOk()
        ->assertJsonPath('data.relationships.country.data.type', 'countries')
        ->assertJsonPath('included.0.id', (string)$country->getKey())
        ->assertJsonPath('included.0.attributes.country_name', 'United Kingdom')
        ->assertJsonPath('included.0.attributes.iso_code_2', 'GB');
});

it('creates an address', function(): void {
    Sanctum::actingAs(User::factory()->create(), ['addresses:*']);
    $customer = Customer::factory()->create();

    $this
        ->post(route('igniter.api.addresses.store'), [
            'customer_id' => $customer->getKey(),
            'address_1' => '1 New Road',
            'address_2' => 'Unit 2',
            'city' => 'Manchester',
            'state' => 'Lancashire',
            'postcode' => 'M1 1AA',
            'country_id' => 1,
        ])
        ->assertCreated()
        ->assertJsonPath('data.attributes.address_1', '1 New Road')
        ->assertJsonPath('data.attributes.city', 'Manchester')
        ->assertJsonPath('data.attributes.customer_id', $customer->getKey());
});

it('creates an address as customer', function(): void {
    $customer = Sanctum::actingAs(Customer::factory()->create(), ['addresses:*']);

    $this
        ->post(route('igniter.api.addresses.store'), [
            'address_1' => '2 Customer Lane',
            'city' => 'Birmingham',
            'country_id' => 1,
        ])
        ->assertCreated()
        ->assertJsonPath('data.attributes.address_1', '2 Customer Lane')
        ->assertJsonPath('data.attributes.customer_id', $customer->getKey());
});

it('updates an address', function(): void {
    Sanctum::actingAs(User::factory()->create(), ['addresses:*']);
    $customer = Customer::factory()->create();
    $address = $customer->addresses()->create([
        'address_1' => '123 Old St',
        'city' => 'London',
        'country_id' => 1,
    ]);

    $this
        ->put(route('igniter.api.addresses.update', [$address->getKey()]), [
            'address_1' => '123 Updated St',
            'city' => 'London',
            'country_id' => 1,
        ])
        ->assertOk()
        ->assertJsonPath('data.attributes.address_1', '123 Updated St');
});

it('deletes an address', function(): void {
    Sanctum::actingAs(User::factory()->create(), ['addresses:*']);
    $customer = Customer::factory()->create();
    $address = $customer->addresses()->create([
        'address_1' => '123 To Delete',
        'city' => 'London',
        'country_id' => 1,
    ]);

    $this
        ->delete(route('igniter.api.addresses.destroy', [$address->getKey()]))
        ->assertStatus(204);

    expect(Address::find($address->getKey()))->toBeNull();
});
