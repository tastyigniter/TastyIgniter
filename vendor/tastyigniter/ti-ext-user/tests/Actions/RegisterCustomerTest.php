<?php

declare(strict_types=1);

namespace Igniter\User\Tests\Actions;

use Igniter\Flame\Exception\ApplicationException;
use Igniter\Flame\Exception\SystemException;
use Igniter\User\Actions\RegisterCustomer;
use Igniter\User\Facades\Auth;
use Igniter\User\Models\Customer;
use Igniter\User\Models\CustomerGroup;
use Illuminate\Support\Facades\Event;
use Mockery;

it('registers customer with provided customer group and fires events correctly', function(): void {
    Event::fake();
    $customerGroup = CustomerGroup::factory()->create(['approval' => false]);

    $data = ['email' => 'user@example.com', 'password' => 'password', 'customer_group_id' => $customerGroup->getKey()];
    Auth::shouldReceive('getProvider->register')->with($data, true)->andReturn(Mockery::mock(Customer::class));
    Auth::shouldReceive('login')->once();

    $result = (new RegisterCustomer)->handle($data);

    expect($result)->toBeInstanceOf(Customer::class);

    Event::assertDispatched('igniter.user.beforeRegister', fn($eventName, $eventPayload): bool => $eventPayload[0] === $data);
    Event::assertDispatched('igniter.user.register', fn($eventName, $eventPayload): bool => $eventPayload[0] === $result && $eventPayload[1] === $data);
});

it('registers customer with default customer group and fires events correctly', function(): void {
    Event::fake();
    $data = ['email' => 'user@example.com', 'password' => 'password', 'customer_group_id' => CustomerGroup::getDefault()->getKey()];
    Auth::shouldReceive('getProvider->register')->with($data, true)->andReturn(Mockery::mock(Customer::class));
    Auth::shouldReceive('login')->once();

    $result = (new RegisterCustomer)->handle(array_except($data, ['customer_group_id']));

    expect($result)->toBeInstanceOf(Customer::class);

    Event::assertDispatched('igniter.user.beforeRegister', fn($eventName, $eventPayload): bool => $eventPayload[0] === $data);
    Event::assertDispatched('igniter.user.register', fn($eventName, $eventPayload): bool => $eventPayload[0] === $result && $eventPayload[1] === $data);
});

it('registers customer with activation required', function(): void {
    Event::fake();
    $customerGroup = CustomerGroup::factory()->create(['approval' => true]);
    $data = ['email' => 'user@example.com', 'password' => 'password', 'customer_group_id' => $customerGroup->getKey()];
    Auth::shouldReceive('getProvider->register')->with($data, false)->andReturn(Mockery::mock(Customer::class));
    Auth::shouldReceive('login')->never();

    $result = (new RegisterCustomer)->handle($data, false);

    expect($result)->toBeInstanceOf(Customer::class);
});

it('throws exception when activation code is invalid', function(): void {
    expect(fn() => (new RegisterCustomer)->activate('invalid_code'))->toThrow(
        ApplicationException::class, lang('igniter.user::default.reset.alert_activation_failed'),
    );
});

it('throws exception when activation fails', function(): void {
    Customer::factory()->create([
        'status' => false,
        'is_activated' => true,
        'activation_code' => 'valid_code',
    ]);

    expect(fn() => (new RegisterCustomer)->activate('valid_code'))->toThrow(
        SystemException::class, 'User is already active!',
    );
});

it('activates customer and logs in successfully', function(): void {
    $customer = Customer::factory()->create([
        'status' => false,
        'is_activated' => false,
        'activation_code' => 'valid_code',
    ]);
    Auth::shouldReceive('login')->once();

    $result = (new RegisterCustomer)->activate('valid_code');

    expect($result->getKey())->toBe($customer->getKey());
});
