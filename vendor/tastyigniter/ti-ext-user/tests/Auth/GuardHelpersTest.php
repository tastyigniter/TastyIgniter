<?php

declare(strict_types=1);

namespace Igniter\User\Tests\Auth;

use Igniter\User\Auth\UserGuard;
use Igniter\User\Models\User;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Session\Store;
use Mockery;

it('logs in user and triggers before and after login events', function(): void {
    $user = Mockery::mock(User::class)->makePartial();
    $guard = Mockery::mock(UserGuard::class)->makePartial()->shouldAllowMockingProtectedMethods();
    $user->shouldReceive('beforeLogin')->once();
    $user->shouldReceive('afterLogin')->once();
    $guard->shouldReceive('login')->passthru();
    $guard->shouldReceive('updateSession')->once();
    $guard->shouldReceive('fireLoginEvent')->once();
    $guard->shouldReceive('setUser')->once();

    $guard->login($user);
});

it('retrieves user by id', function(): void {
    $user = Mockery::mock(User::class)->makePartial();
    $provider = Mockery::mock(UserProvider::class);
    $guard = Mockery::mock(UserGuard::class)->makePartial();
    $provider->shouldReceive('retrieveById')->with(1)->andReturn($user);
    $guard->shouldReceive('getProvider')->andReturn($provider);

    $result = $guard->getById(1);

    expect($result)->toBe($user);
});

it('retrieves user by token', function(): void {
    $user = Mockery::mock(User::class)->makePartial();
    $provider = Mockery::mock(UserProvider::class);
    $guard = Mockery::mock(UserGuard::class)->makePartial();
    $provider->shouldReceive('retrieveByToken')->with(1, 'token')->andReturn($user);
    $guard->shouldReceive('getProvider')->andReturn($provider);

    $result = $guard->getByToken(1, 'token');

    expect($result)->toBe($user);
});

it('retrieves user by credentials', function(): void {
    $user = Mockery::mock(User::class)->makePartial();
    $provider = Mockery::mock(UserProvider::class);
    $guard = Mockery::mock(UserGuard::class)->makePartial();
    $provider->shouldReceive('retrieveByCredentials')->with(['email' => 'test@example.com'])->andReturn($user);
    $guard->shouldReceive('getProvider')->andReturn($provider);

    $result = $guard->getByCredentials(['email' => 'test@example.com']);

    expect($result)->toBe($user);
});

it('validates user credentials', function(): void {
    $user = Mockery::mock(User::class)->makePartial();
    $provider = Mockery::mock(UserProvider::class);
    $guard = Mockery::mock(UserGuard::class)->makePartial();
    $provider->shouldReceive('validateCredentials')->with($user, ['password' => 'secret'])->andReturn(true);
    $guard->shouldReceive('getProvider')->andReturn($provider);

    $result = $guard->validateCredentials($user, ['password' => 'secret']);

    expect($result)->toBeTrue();
});

it('impersonates user and sets session properties', function(): void {
    $user = Mockery::mock(User::class)->makePartial();
    $oldUser = Mockery::mock(User::class)->makePartial();
    $session = Mockery::mock(Store::class);
    $guard = Mockery::mock(UserGuard::class)->makePartial();
    setObjectProtectedProperty($guard, 'session', $session);
    $session->shouldReceive('get')->with('login')->andReturn(1);
    $session->shouldReceive('has')->with('login_impersonate')->andReturnFalse()->once();
    $session->shouldReceive('put')->with('login_impersonate', 1)->once();
    $guard->shouldReceive('getName')->andReturn('login');
    $guard->shouldReceive('getById')->with(1)->andReturn($oldUser);
    $guard->shouldReceive('login')->with($user);
    $user->shouldReceive('fireEvent')->with('model.auth.beforeImpersonate', [$oldUser])->once();

    $guard->impersonate($user);
});

it('stops impersonation and restores original user', function(): void {
    $user = Mockery::mock(User::class)->makePartial();
    $oldUser = Mockery::mock(User::class)->makePartial();
    $session = Mockery::mock(Store::class);
    $guard = Mockery::mock(UserGuard::class)->makePartial();
    $guard->shouldReceive('getById')->with(1)->andReturn($oldUser);
    $guard->shouldReceive('getById')->with(2)->andReturn($user);
    $session->shouldReceive('get')->with('login')->andReturn(2);
    $session->shouldReceive('pull')->with('login_impersonate')->andReturn(1);
    $session->shouldReceive('remove')->with('login');
    setObjectProtectedProperty($guard, 'session', $session);
    $guard->shouldReceive('getName')->andReturn('login');
    $guard->shouldReceive('login')->with($oldUser);
    $user->shouldReceive('fireEvent')->with('model.auth.afterImpersonate', [$oldUser])->once();

    $guard->stopImpersonate();
});

it('checks if user is impersonator', function(): void {
    $session = Mockery::mock(Store::class);
    $guard = Mockery::mock(UserGuard::class)->makePartial();
    $guard->shouldReceive('getName')->andReturn('login');
    $session->shouldReceive('has')->with('login_impersonate')->andReturn(true);
    setObjectProtectedProperty($guard, 'session', $session);

    $result = $guard->isImpersonator();

    expect($result)->toBeTrue();
});

it('retrieves impersonator user', function(): void {
    $user = Mockery::mock(User::class)->makePartial();
    $session = Mockery::mock(Store::class);
    $guard = Mockery::mock(UserGuard::class)->makePartial();
    $guard->shouldReceive('getName')->andReturn('login');
    $session->shouldReceive('get')->with('login_impersonate')->andReturn(1);
    setObjectProtectedProperty($guard, 'session', $session);
    $guard->shouldReceive('getById')->with(1)->andReturn($user);

    $result = $guard->getImpersonator();

    expect($result)->toBe($user);
});

it('retrieves impersonator user returns false', function(): void {
    $user = Mockery::mock(User::class)->makePartial();
    $session = Mockery::mock(Store::class);
    $guard = Mockery::mock(UserGuard::class)->makePartial();
    $guard->shouldReceive('getName')->andReturn('login');
    $session->shouldReceive('get')->with('login_impersonate')->andReturn(null);
    setObjectProtectedProperty($guard, 'session', $session);

    expect($guard->getImpersonator())->toBeNull();
});
