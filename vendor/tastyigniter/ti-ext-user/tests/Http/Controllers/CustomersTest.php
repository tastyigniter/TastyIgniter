<?php

declare(strict_types=1);

namespace Igniter\User\Tests\Http\Controllers;

use Igniter\Flame\Exception\FlashException;
use Igniter\User\Http\Controllers\Customers;
use Igniter\User\Models\Customer;
use Illuminate\Contracts\Auth\Access\Gate;
use Illuminate\Http\RedirectResponse;
use Mockery;

it('loads customers page', function(): void {
    actingAsSuperUser()
        ->get(route('igniter.user.customers'))
        ->assertOk();
});

it('loads create customer page', function(): void {
    actingAsSuperUser()
        ->get(route('igniter.user.customers', ['slug' => 'create']))
        ->assertOk();
});

it('loads edit customer page', function(): void {
    $customer = Customer::factory()->create();

    actingAsSuperUser()
        ->get(route('igniter.user.customers', ['slug' => 'edit/'.$customer->getKey()]))
        ->assertOk();
});

it('loads customer preview page', function(): void {
    $customer = Customer::factory()->create();

    actingAsSuperUser()
        ->get(route('igniter.user.customers', ['slug' => 'preview/'.$customer->getKey()]))
        ->assertOk();
});

it('creates customer when send invite is checked and missing password', function(): void {
    actingAsSuperUser()
        ->post(route('igniter.user.customers', ['slug' => 'create']), [
            'Customer' => [
                'first_name' => 'John',
                'last_name' => 'Doe',
                'email' => 'user@example.com',
                'customer_group_id' => 1,
                'send_invite' => 1,
                'newsletter' => 1,
                'status' => 1,
            ],
        ], [
            'X-Requested-With' => 'XMLHttpRequest',
            'X-IGNITER-REQUEST-HANDLER' => 'onSave',
        ]);

    expect(Customer::query()
        ->where('email', 'user@example.com')
        ->where('first_name', 'John')
        ->whereNull('password')
        ->whereNotNull('reset_code')
        ->exists(),
    )->toBeTrue();
});

it('creates customer when send invite is unchecked and password provided', function(): void {
    actingAsSuperUser()
        ->post(route('igniter.user.customers', ['slug' => 'create']), [
            'Customer' => [
                'first_name' => 'John',
                'last_name' => 'Doe',
                'email' => 'user@example.com',
                'send_invite' => 0,
                'password' => 'password',
                'password_confirm' => 'password',
                'customer_group_id' => 1,
                'newsletter' => 1,
                'status' => 1,
            ],
        ], [
            'X-Requested-With' => 'XMLHttpRequest',
            'X-IGNITER-REQUEST-HANDLER' => 'onSave',
        ]);

    expect(Customer::query()
        ->where('email', 'user@example.com')
        ->where('first_name', 'John')
        ->whereNotNull('password')
        ->whereNull('reset_code')
        ->exists(),
    )->toBeTrue();
});

it('does not create customer when send invite is unchecked or password is missing', function(): void {
    actingAsSuperUser()
        ->post(route('igniter.user.customers', ['slug' => 'create']), [
            'Customer' => [
                'first_name' => 'John',
                'last_name' => 'Doe',
                'email' => 'user@example.com',
                'customer_group_id' => 1,
                'newsletter' => 1,
                'status' => 1,
            ],
        ], [
            'X-Requested-With' => 'XMLHttpRequest',
            'X-IGNITER-REQUEST-HANDLER' => 'onSave',
        ])
        ->assertSee('The send invite field must be present.');

    actingAsSuperUser()
        ->post(route('igniter.user.customers', ['slug' => 'create']), [
            'Customer' => [
                'first_name' => 'John',
                'last_name' => 'Doe',
                'email' => 'user@example.com',
                'send_invite' => 0,
                'customer_group_id' => 1,
                'newsletter' => 1,
                'status' => 1,
            ],
        ], [
            'X-Requested-With' => 'XMLHttpRequest',
            'X-IGNITER-REQUEST-HANDLER' => 'onSave',
        ])
        ->assertSee('The Password field is required when send invite is declined.');
});

it('updates customer', function(): void {
    $customer = Customer::factory()->create(['is_activated' => false]);

    actingAsSuperUser()
        ->patch(route('igniter.user.customers', ['slug' => 'edit/'.$customer->getKey()]), [
            'Customer' => [
                'first_name' => 'John',
                'last_name' => 'Doe',
                'email' => 'user@example.com',
                'customer_group_id' => 1,
                'newsletter' => 1,
                'status' => 1,
            ],
        ], [
            'X-Requested-With' => 'XMLHttpRequest',
            'X-IGNITER-REQUEST-HANDLER' => 'onSave',
        ]);

    expect(Customer::where('email', 'user@example.com')->where('first_name', 'John')->exists())->toBeTrue();
});

it('deletes customer', function(): void {
    $customer = Customer::factory()->create();

    actingAsSuperUser()
        ->post(route('igniter.user.customers', ['slug' => 'edit/'.$customer->getKey()]), [], [
            'X-Requested-With' => 'XMLHttpRequest',
            'X-IGNITER-REQUEST-HANDLER' => 'onDelete',
        ]);

    expect(Customer::find($customer->getKey()))->toBeNull();
});

it('bulk deletes customers', function(): void {
    $customer = Customer::factory()->count(5)->create();
    $customerIds = $customer->pluck('customer_id')->all();

    actingAsSuperUser()
        ->post(route('igniter.user.customers'), [
            'checked' => $customerIds,
        ], [
            'X-Requested-With' => 'XMLHttpRequest',
            'X-IGNITER-REQUEST-HANDLER' => 'onDelete',
        ]);

    expect(Customer::whereIn('customer_id', $customerIds)->exists())->toBeFalse();
});

it('throws exception when unauthorized to delete customer', function(): void {
    $authGate = Mockery::mock(Gate::class);
    $authGate->shouldReceive('inspect')->with('Admin.DeleteCustomers')->andReturnSelf();
    $authGate->shouldReceive('allowed')->andReturnFalse();
    app()->instance(Gate::class, $authGate);

    $this->expectException(FlashException::class);
    $this->expectExceptionMessage(lang('igniter::admin.alert_user_restricted'));

    (new Customers)->index_onDelete();
});

it('impersonates customer successfully', function(): void {
    $customer = Customer::factory()->create([
        'first_name' => 'John',
        'last_name' => 'Doe',
    ]);
    $authGate = Mockery::mock(Gate::class);
    $authGate->shouldReceive('inspect')->with('Admin.ImpersonateCustomers')->andReturnSelf();
    $authGate->shouldReceive('allowed')->andReturnTrue();
    app()->instance(Gate::class, $authGate);

    (new Customers)->onImpersonate('edit', $customer->getKey());

    expect(flash()->messages()->first())
        ->level->toBe('success')
        ->message->toBe(sprintf(lang('igniter.user::default.customers.alert_impersonate_success'), 'John Doe'));
});

it('throws exception when unauthorized to impersonate customer', function(): void {
    $customer = Customer::factory()->create([
        'first_name' => 'John',
        'last_name' => 'Doe',
    ]);
    $authGate = Mockery::mock(Gate::class);
    $authGate->shouldReceive('inspect')->with('Admin.ImpersonateCustomers')->andReturnSelf();
    $authGate->shouldReceive('allowed')->andReturnFalse();
    app()->instance(Gate::class, $authGate);

    $this->expectException(FlashException::class);
    $this->expectExceptionMessage(lang('igniter.user::default.customers.alert_login_restricted'));

    (new Customers)->onImpersonate('edit', $customer->getKey());
});

it('activates customer successfully', function(): void {
    $customer = Customer::factory()->create(['is_activated' => false]);

    $response = (new Customers)->edit_onActivate('context', $customer->getKey());

    expect($response)->toBeInstanceOf(RedirectResponse::class)
        ->and(flash()->messages()->first())
        ->level->toBe('success')
        ->message->toBe(lang('igniter.user::default.customers.alert_activation_success'));
});
