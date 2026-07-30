<?php

declare(strict_types=1);

namespace Igniter\Api\Tests\ApiResources;

use Igniter\Admin\Models\Status;
use Igniter\Cart\Models\Order;
use Igniter\Local\Models\Location;
use Igniter\User\Models\Address;
use Igniter\User\Models\Customer;
use Igniter\User\Models\User;
use Igniter\User\Models\UserGroup;
use Illuminate\Support\Facades\Mail;
use Laravel\Sanctum\Sanctum;

it('returns all orders', function(): void {
    Sanctum::actingAs(User::factory()->create(), ['orders:*']);
    Order::factory()->count(3)->create();
    $order = Order::first();

    $this
        ->get(route('igniter.api.orders.index'))
        ->assertOk()
        ->assertJsonPath('data.0.id', (string)$order->getKey())
        ->assertJsonPath('data.0.attributes.email', $order->email);
});

it('shows an order', function(): void {
    Sanctum::actingAs(User::factory()->create(), ['orders:*']);
    $order = Order::factory()->create();

    $this
        ->get(route('igniter.api.orders.show', [$order->getKey()]))
        ->assertOk()
        ->assertJsonPath('data.id', (string)$order->getKey())
        ->assertJsonPath('data.attributes.email', $order->email);
});

it('shows an order with customer relationship', function(): void {
    Sanctum::actingAs(User::factory()->create(), ['orders:*']);
    $order = Order::factory()->create();
    $order->customer()->associate($orderCustomer = Customer::factory()->create(['first_name' => 'Test', 'last_name' => 'User']))->save();

    $this
        ->get(route('igniter.api.orders.show', [$order->getKey()]).'?'.
            http_build_query(['include' => 'customer']))
        ->assertOk()
        ->assertJsonPath('data.relationships.customer.data.type', 'customers')
        ->assertJsonPath('included.0.id', (string)$orderCustomer->getKey())
        ->assertJsonPath('included.0.attributes.full_name', 'Test User');
});

it('shows an order with location relationship', function(): void {
    Sanctum::actingAs(User::factory()->create(), ['orders:*']);
    $order = Order::factory()->create();
    $order->location()->associate($orderLocation = Location::factory()->create())->save();

    $this
        ->get(route('igniter.api.orders.show', [$order->getKey()]).'?'.
            http_build_query(['include' => 'location']))
        ->assertOk()
        ->assertJsonPath('data.relationships.location.data.type', 'locations')
        ->assertJsonPath('included.0.id', (string)$orderLocation->getKey())
        ->assertJsonPath('included.0.attributes.location_name', $order->location->location_name);
});

it('shows an order with address relationship', function(): void {
    Sanctum::actingAs(User::factory()->create(), ['orders:*']);
    $order = Order::factory()->create();
    $order->address()->associate(
        $orderAddress = Address::factory()->create(['address_1' => '123 Test St', 'country_id' => 123]),
    )->save();

    $this
        ->get(route('igniter.api.orders.show', [$order->getKey()]).'?'.
            http_build_query(['include' => 'address']))
        ->assertOk()
        ->assertJsonPath('data.relationships.address.data.type', 'addresses')
        ->assertJsonPath('included.0.id', (string)$orderAddress->getKey())
        ->assertJsonPath('included.0.attributes.address_1', '123 Test St');
});

it('shows an order with payment_method relationship', function(): void {
    Sanctum::actingAs(User::factory()->create(), ['orders:*']);
    $order = Order::factory()->create([
        'payment' => 'cod',
    ]);

    $this
        ->get(route('igniter.api.orders.show', [$order->getKey()]).'?'.
            http_build_query(['include' => 'payment_method']))
        ->assertOk()
        ->assertJsonPath('data.relationships.payment_method.data.type', 'payment_methods')
        ->assertJsonPath('included.0.attributes.code', 'cod');
});

it('shows an order with status relationship', function(): void {
    Sanctum::actingAs(User::factory()->create(), ['orders:*']);
    $order = Order::factory()->create();
    $order->status()->associate($orderStatus = Status::isForOrder()->first())->save();

    $this
        ->get(route('igniter.api.orders.show', [$order->getKey()]).'?'.
            http_build_query(['include' => 'status']))
        ->assertOk()
        ->assertJsonPath('data.relationships.status.data.type', 'statuses')
        ->assertJsonPath('included.0.id', (string)$orderStatus->getKey())
        ->assertJsonPath('included.0.attributes.name', $order->status->name);
});

it('shows an order with status_history relationship', function(): void {
    Sanctum::actingAs(User::factory()->create(), ['orders:*']);
    $order = Order::factory()->create();
    $orderStatusHistory = $order->status_history()->create(['status_id' => Status::isForOrder()->first()->getKey()]);

    $this
        ->get(route('igniter.api.orders.show', [$order->getKey()]).'?'.
            http_build_query(['include' => 'status_history']))
        ->assertOk()
        ->assertJsonPath('data.relationships.status_history.data.0.type', 'status_history')
        ->assertJsonPath('included.0.id', (string)$orderStatusHistory->getKey())
        ->assertJsonPath('included.0.attributes.status_id', $orderStatusHistory->status_id);
});

it('shows an order with assignee relationship', function(): void {
    Sanctum::actingAs(User::factory()->create(), ['orders:*']);
    $order = Order::factory()->create();
    $assignee = User::factory()->create();
    $order->assignee()->associate($assignee)->save();

    $this
        ->get(route('igniter.api.orders.show', [$order->getKey()]).'?'.
            http_build_query(['include' => 'assignee']))
        ->assertOk()
        ->assertJsonPath('data.relationships.assignee.data.type', 'assignee')
        ->assertJsonPath('included.0.id', (string)$assignee->getKey())
        ->assertJsonPath('included.0.attributes.name', $assignee->name);
});

it('shows an order with assignee_group relationship', function(): void {
    Sanctum::actingAs(User::factory()->create(), ['orders:*']);
    $order = Order::factory()->create();
    $order->assignee_group()->associate(
        $orderAssigneeGroup = UserGroup::factory()->create(['user_group_name' => 'Test Group']),
    )->save();

    $this
        ->get(route('igniter.api.orders.show', [$order->getKey()]).'?'.
            http_build_query(['include' => 'assignee_group']))
        ->assertOk()
        ->assertJsonPath('data.relationships.assignee_group.data.type', 'assignee_group')
        ->assertJsonPath('included.0.id', (string)$orderAssigneeGroup->getKey())
        ->assertJsonPath('included.0.attributes.user_group_name', 'Test Group');
});

it('creates an order', function(): void {
    Mail::fake();

    Sanctum::actingAs(User::factory()->create(), ['orders:*']);

    $this
        ->post(route('igniter.api.orders.store'), [
            'first_name' => 'Test',
            'last_name' => 'User',
            'email' => 'test-user@domain.tld',
            'telephone' => '1234567890',
            'comment' => '123 Test St',
            'payment' => 'cod',
            'status_id' => Status::isForOrder()->first()->getKey(),
            'order_type' => Location::DELIVERY,
            'processed' => true,
            'address' => [
                'address_1' => '123 Test St',
                'city' => 'Test City',
                'postcode' => '12345',
                'state' => 'Test State',
                'country_id' => '123',
            ],
            'order_menus' => [
                [
                    'id' => 123,
                    'name' => 'foo',
                    'qty' => 1,
                    'price' => '12.23',
                    'subtotal' => '12.23',
                    'comment' => '',
                    'options' => [],
                ],
            ],
            'order_totals' => [
                ['code' => 'subtotal', 'title' => 'Subtotal', 'value' => '12.23'],
                ['code' => 'total', 'title' => 'Total', 'value' => '12.23'],
            ],
        ])
        ->assertCreated()
        ->assertJsonPath('data.attributes.email', 'test-user@domain.tld');
});

it('updates an order', function(): void {
    Mail::fake();

    Sanctum::actingAs(User::factory()->create(), ['orders:*']);
    $order = Order::factory()->create();

    expect($order->order_type)->toBe(Location::DELIVERY);

    $this
        ->put(route('igniter.api.orders.update', [$order->getKey()]), [
            'order_type' => Location::COLLECTION,
        ])
        ->assertOk()
        ->assertJsonPath('data.attributes.order_type', Location::COLLECTION);
});

it('updates order status', function(): void {
    Sanctum::actingAs(User::factory()->create(), ['orders:*']);
    $order = Order::factory()->create();
    $newStatus = Status::isForOrder()->first();

    $this
        ->patch(route('igniter.api.orders.update_status', [$order->getKey()]), [
            'status_id' => $newStatus->getKey(),
        ])
        ->assertOk()
        ->assertJsonPath('data.id', (string)$order->getKey())
        ->assertJsonPath('data.attributes.status_id', $newStatus->getKey());
});

it('updates order status with comment', function(): void {
    Sanctum::actingAs(User::factory()->create(), ['orders:*']);
    $order = Order::factory()->create();
    $newStatus = Status::isForOrder()->first();

    $this
        ->patch(route('igniter.api.orders.update_status', [$order->getKey()]), [
            'status_id' => $newStatus->getKey(),
            'status_comment' => 'Ready for collection',
        ])
        ->assertOk()
        ->assertJsonPath('data.attributes.status_id', $newStatus->getKey());
});

it('fails to update order status when status_id is missing', function(): void {
    Sanctum::actingAs(User::factory()->create(), ['orders:*']);
    $order = Order::factory()->create();

    $this
        ->patch(route('igniter.api.orders.update_status', [$order->getKey()]), [
            'status_comment' => 'Comment only',
        ])
        ->assertStatus(422);
});

it('can not update order status as customer', function(): void {
    $customer = Sanctum::actingAs(Customer::factory()->create(), ['orders:*']);
    $customer->currentAccessToken()->shouldReceive('isForCustomer')->andReturnTrue();
    $order = Order::factory()->create();
    $newStatus = Status::isForOrder()->first();

    $this
        ->patch(route('igniter.api.orders.update_status', [$order->getKey()]), [
            'status_id' => $newStatus->getKey(),
        ])
        ->assertStatus(403);
});

it('deletes an order', function(): void {
    Sanctum::actingAs(User::factory()->create(), ['orders:*']);
    $order = Order::factory()->create();

    $this
        ->delete(route('igniter.api.orders.destroy', [$order->getKey()]))
        ->assertStatus(204);

    expect(Order::find($order->getKey()))->toBeNull();
});
