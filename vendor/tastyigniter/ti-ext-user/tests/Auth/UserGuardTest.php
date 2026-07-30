<?php

declare(strict_types=1);

namespace Igniter\User\Tests\Auth;

use Igniter\User\Auth\UserGuard;
use Igniter\User\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Mockery;

it('checks if user is logged in', function(): void {
    $guard = Mockery::mock(UserGuard::class)->makePartial();
    $guard->shouldReceive('check')->andReturn(true);

    $result = $guard->isLogged();

    expect($result)->toBeTrue();
});

it('checks if user is super user', function(): void {
    $user = Mockery::mock(User::class)->makePartial();
    $guard = Mockery::mock(UserGuard::class)->makePartial();
    $user->shouldReceive('isSuperUser')->andReturn(true);
    $guard->setUser($user);

    expect($guard->isSuperUser())->toBeTrue();
});

it('returns staff instance', function(): void {
    $user = Mockery::mock(User::class)->makePartial();
    $guard = Mockery::mock(UserGuard::class)->makePartial();
    $guard->shouldReceive('user')->andReturn($user);

    $result = $guard->staff();

    expect($result)->toBe($user);
});

it('returns user locations', function(): void {
    $locations = Mockery::mock(Collection::class);
    $user = Mockery::mock(User::class)->makePartial();
    $guard = Mockery::mock(UserGuard::class)->makePartial();
    $guard->setUser($user);
    $user->shouldReceive('getAttribute')->with('locations')->andReturn($locations);

    expect($guard->locations())->toBe($locations);
});

it('returns user id', function(): void {
    $guard = Mockery::mock(UserGuard::class)->makePartial();
    $guard->shouldReceive('id')->andReturn(1);

    $result = $guard->getId();

    expect($result)->toBe(1);
});

it('returns user name', function(): void {
    $user = Mockery::mock(User::class)->makePartial();
    $user->username = 'john_doe';
    $guard = Mockery::mock(UserGuard::class)->makePartial();
    $guard->setUser($user);

    $result = $guard->getUserName();

    expect($result)->toBe('john_doe');
});

it('returns user email', function(): void {
    $user = Mockery::mock(User::class)->makePartial();
    $user->email = 'john.doe@example.com';
    $guard = Mockery::mock(UserGuard::class)->makePartial();
    $guard->setUser($user);

    $result = $guard->getUserEmail();

    expect($result)->toBe('john.doe@example.com');
});

it('returns staff name', function(): void {
    $user = Mockery::mock(User::class)->makePartial();
    $user->name = 'John Doe';
    $guard = Mockery::mock(UserGuard::class)->makePartial();
    $guard->setUser($user);

    $result = $guard->getStaffName();

    expect($result)->toBe('John Doe');
});

it('returns staff email', function(): void {
    $user = Mockery::mock(User::class)->makePartial();
    $user->email = 'john.doe@example.com';
    $guard = Mockery::mock(UserGuard::class)->makePartial();
    $guard->setUser($user);

    $result = $guard->getStaffEmail();

    expect($result)->toBe('john.doe@example.com');
});
