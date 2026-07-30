<?php

declare(strict_types=1);

namespace Igniter\Api\Tests\ApiResources;

use Igniter\User\Models\Customer;
use Igniter\User\Models\User;
use Laravel\Sanctum\Sanctum;

it('can not update customer aware column', function(): void {
    Sanctum::actingAs($customer = Customer::factory()->create(), ['customers:*']);

    $this
        ->put(route('igniter.api.customers.update', [$customer->getKey()]), [
            'customer_id' => 9999,
            'first_name' => 'Test',
            'last_name' => 'Customer',
            'email' => 'test@example.tld',
            'customer_group_id' => 1,
            'newsletter' => false,
            'status' => false,
        ])
        ->assertOk()
        ->assertJsonPath('data.attributes.full_name', 'Test Customer')
        ->assertJsonMissing(['customer_id' => 9999]);
});

it('returns only authenticated customer', function(): void {
    Customer::factory()->count(5)->create();
    Sanctum::actingAs($customer = Customer::factory()->create(), ['customers:*']);

    $this
        ->get(route('igniter.api.customers.index'))
        ->assertOk()
        ->assertJsonPath('data.0.attributes.full_name', $customer->full_name)
        ->assertJsonCount(1, 'data');
});

it('can not show unauthenticated customer', function(): void {
    $anotherCustomer = Customer::factory()->create();
    Sanctum::actingAs(Customer::factory()->create(), ['customers:*']);

    $this
        ->get(route('igniter.api.customers.show', [$anotherCustomer->getKey()]))
        ->assertStatus(404);
});

it('returns all customers', function(): void {
    Sanctum::actingAs(User::factory()->create(), ['customers:*']);
    Customer::factory()->count(5)->create();
    $customer = Customer::first();

    $this
        ->get(route('igniter.api.customers.index'))
        ->assertOk()
        ->assertJsonPath('data.0.id', (string)$customer->getKey())
        ->assertJsonPath('data.0.attributes.name', $customer->name)
        ->assertJsonCount(5, 'data');
});

it('shows a customer', function(): void {
    Sanctum::actingAs(User::factory()->create(), ['customers:*']);
    $customer = Customer::factory()->create();

    $this
        ->get(route('igniter.api.customers.show', [$customer->getKey()]))
        ->assertOk()
        ->assertJsonPath('data.id', (string)$customer->getKey())
        ->assertJsonPath('data.attributes.full_name', $customer->full_name);
});

it('shows a customer with addresses relationship', function(): void {
    Sanctum::actingAs(User::factory()->create(), ['customers:*']);
    $customer = Customer::factory()->create();
    $customerAddress = $customer->addresses()->create(['address_1' => '123 Test Address', 'country_id' => 1]);

    $this
        ->get(route('igniter.api.customers.show', [$customer->getKey()]).'?'.http_build_query([
            'include' => 'addresses',
        ]))
        ->assertOk()
        ->assertJsonPath('data.relationships.addresses.data.0.type', 'addresses')
        ->assertJsonPath('included.0.id', (string)$customerAddress->getKey())
        ->assertJsonPath('included.0.attributes.address_1', '123 Test Address');
});

it('shows a customer with orders relationship', function(): void {
    Sanctum::actingAs(User::factory()->create(), ['customers:*']);
    $customer = Customer::factory()->create();
    $customerOrder = $customer->orders()->create(['order_type' => 'collection']);

    $this
        ->get(route('igniter.api.customers.show', [$customer->getKey()]).'?'.http_build_query([
            'include' => 'orders',
        ]))
        ->assertOk()
        ->assertJsonPath('data.relationships.orders.data.0.type', 'orders')
        ->assertJsonPath('included.0.id', (string)$customerOrder->getKey())
        ->assertJsonPath('included.0.attributes.order_type', 'collection');
});

it('shows a customer with reservations relationship', function(): void {
    Sanctum::actingAs(User::factory()->create(), ['customers:*']);
    $customer = Customer::factory()->create();
    $customerReservation = $customer->reservations()->create(['email' => 'user-reservation@example.com']);

    $this
        ->get(route('igniter.api.customers.show', [$customer->getKey()]).'?'.http_build_query([
            'include' => 'reservations',
        ]))
        ->assertOk()
        ->assertJsonPath('data.relationships.reservations.data.0.type', 'reservations')
        ->assertJsonPath('included.0.id', (string)$customerReservation->getKey())
        ->assertJsonPath('included.0.attributes.email', 'user-reservation@example.com');
});

it('creates a customer', function(): void {
    Sanctum::actingAs(User::factory()->create(), ['customers:*']);

    $this
        ->post(route('igniter.api.customers.store'), [
            'first_name' => 'Test',
            'last_name' => 'Customer',
            'email' => 'test@example.tld',
            'customer_group_id' => 1,
            'send_invite' => 1,
            'newsletter' => false,
            'status' => false,
        ])
        ->assertCreated()
        ->assertJsonPath('data.attributes.full_name', 'Test Customer');
});

it('creates a customer as customer', function(): void {
    $customer = Sanctum::actingAs(Customer::factory()->create(), ['customers:*']);

    $customer->currentAccessToken()->shouldReceive('isForCustomer')->andReturnTrue();

    $this
        ->post(route('igniter.api.customers.store'), [
            'first_name' => 'Test',
            'last_name' => 'Customer',
            'email' => 'test@example.tld',
            'customer_group_id' => 1,
            'send_invite' => 1,
            'newsletter' => false,
            'status' => false,
        ])
        ->assertCreated()
        ->assertJsonPath('data.attributes.full_name', 'Test Customer');
});

it('updates a customer', function(): void {
    Sanctum::actingAs(User::factory()->create(), ['customers:*']);
    $customer = Customer::factory()->create();

    $this
        ->put(route('igniter.api.customers.update', [$customer->getKey()]), [
            'first_name' => 'Test',
            'last_name' => 'Customer',
            'email' => 'test@example.tld',
            'customer_group_id' => 1,
            'newsletter' => false,
            'status' => false,
        ])
        ->assertOk()
        ->assertJsonPath('data.attributes.full_name', 'Test Customer');
});

it('deletes a customer', function(): void {
    Sanctum::actingAs(User::factory()->create(), ['customers:*']);
    $customer = Customer::factory()->create();

    $this
        ->delete(route('igniter.api.customers.destroy', [$customer->getKey()]))
        ->assertStatus(204);
});
