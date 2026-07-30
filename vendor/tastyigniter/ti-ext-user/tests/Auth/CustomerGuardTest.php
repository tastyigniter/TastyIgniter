<?php

declare(strict_types=1);

namespace Igniter\User\Tests\Auth;

use Igniter\User\Auth\CustomerGuard;
use Igniter\User\Models\Customer;
use Mockery;

it('returns the customer instance', function(): void {
    $user = Mockery::mock(Customer::class);
    $guard = Mockery::mock(CustomerGuard::class)->makePartial();
    $guard->shouldReceive('user')->andReturn($user);

    $result = $guard->customer();

    expect($result)->toBe($user);
});

it('checks if customer is logged in', function(): void {
    $guard = Mockery::mock(CustomerGuard::class)->makePartial();
    $guard->shouldReceive('check')->andReturn(true);

    $result = $guard->isLogged();

    expect($result)->toBeTrue();
});

it('returns customer id', function(): void {
    $user = Mockery::mock(Customer::class)->makePartial();
    $guard = Mockery::mock(CustomerGuard::class)->makePartial();
    $user->customer_id = 1;
    $guard->setUser($user);

    $result = $guard->getId();

    expect($result)->toBe(1);
});

it('returns customer full name', function(): void {
    $user = Mockery::mock(Customer::class)->makePartial();
    $guard = Mockery::mock(CustomerGuard::class)->makePartial();
    $user->shouldReceive('extendableGet')->with('full_name')->andReturn('John Doe');
    $guard->setUser($user);

    $result = $guard->getFullName();

    expect($result)->toBe('John Doe');
});

it('returns customer first name', function(): void {
    $user = Mockery::mock(Customer::class)->makePartial();
    $guard = Mockery::mock(CustomerGuard::class)->makePartial();
    $user->first_name = 'John';
    $guard->setUser($user);

    $result = $guard->getFirstName();

    expect($result)->toBe('John');
});

it('returns customer last name', function(): void {
    $user = Mockery::mock(Customer::class)->makePartial();
    $guard = Mockery::mock(CustomerGuard::class)->makePartial();
    $user->last_name = 'Doe';
    $guard->setUser($user);

    $result = $guard->getLastName();

    expect($result)->toBe('Doe');
});

it('returns customer email in lowercase', function(): void {
    $user = Mockery::mock(Customer::class)->makePartial();
    $guard = Mockery::mock(CustomerGuard::class)->makePartial();
    $user->email = 'John.Doe@Example.com';
    $guard->setUser($user);

    $result = $guard->getEmail();

    expect($result)->toBe('john.doe@example.com');
});

it('returns customer telephone', function(): void {
    $user = Mockery::mock(Customer::class)->makePartial();
    $guard = Mockery::mock(CustomerGuard::class)->makePartial();
    $user->telephone = '1234567890';
    $guard->setUser($user);

    $result = $guard->getTelephone();

    expect($result)->toBe('1234567890');
});

it('returns customer address id', function(): void {
    $user = Mockery::mock(Customer::class)->makePartial();
    $guard = Mockery::mock(CustomerGuard::class)->makePartial();
    $user->address_id = 1;
    $guard->setUser($user);

    $result = $guard->getAddressId();

    expect($result)->toBe(1);
});

it('returns customer group id', function(): void {
    $user = Mockery::mock(Customer::class)->makePartial();
    $guard = Mockery::mock(CustomerGuard::class)->makePartial();
    $user->customer_group_id = 1;
    $guard->setUser($user);

    $result = $guard->getGroupId();

    expect($result)->toBe(1);
});
