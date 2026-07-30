<?php

declare(strict_types=1);

namespace Igniter\User\Tests\Auth;

use Igniter\User\Auth\UserProvider;
use Igniter\User\Models\User;
use Illuminate\Support\Facades\Hash;
use Mockery;

it('retrieves user by id', function(): void {
    $user = User::factory()->create(['status' => 1]);
    $provider = new UserProvider(['model' => User::class]);

    $result = $provider->retrieveById($user->getKey());

    expect($result->getKey())->toBe($user->getKey());
});

it('retrieves user by token', function(): void {
    $user = User::factory()->create([
        'remember_token' => 'token',
        'status' => 1,
    ]);

    $provider = new UserProvider(['model' => User::class]);

    $result = $provider->retrieveByToken($user->getKey(), 'token');

    expect($result->getKey())->toBe($user->getKey());
});

it('updates remember token', function(): void {
    $user = User::factory()->create();
    $provider = new UserProvider(['model' => User::class]);

    $provider->updateRememberToken($user, 'new_token');

    expect($user->getRememberToken())->toBe('new_token');
});

it('retrieves user by credentials', function(): void {
    $email = 'test@example.com';
    $user = User::factory()->create(['email' => $email, 'status' => 1]);
    $provider = new UserProvider(['model' => User::class]);

    $result = $provider->retrieveByCredentials(['email' => $email]);

    expect($result->getKey())->toBe($user->getKey());
});

it('validates user credentials', function(): void {
    $user = User::factory()->create(['status' => 1]);
    $provider = Mockery::mock(UserProvider::class)->makePartial();
    $provider->shouldReceive('hasShaPassword')->andReturn(false);
    Hash::shouldReceive('check')->with('password', $user->getAuthPassword())->andReturn(true);

    $result = $provider->validateCredentials($user, ['password' => 'password']);

    expect($result)->toBeTrue();
});

it('validates user credentials converts SHA1 passwords to bcrypt', function(): void {
    $user = Mockery::mock(User::class);
    $provider = Mockery::mock(UserProvider::class)->makePartial();
    $provider->shouldReceive('hasShaPassword')->andReturn(true);
    Hash::shouldReceive('check')->with('password', 'hashed_password')->andReturn(true);
    $user->shouldReceive('getAuthPassword')->andReturn('hashed_password');
    $user->shouldReceive('getAuthPasswordName')->andReturn('password');
    Hash::shouldReceive('make')->with('password')->andReturn('hashed_password');
    $user->shouldReceive('forceFill')->with([
        'password' => 'hashed_password',
        'salt' => null,
    ])->andReturnSelf()->once();
    $user->shouldReceive('save')->once();

    $result = $provider->validateCredentials($user, ['password' => 'password']);

    expect($result)->toBeTrue();
});

it('does not validates user credentials when password is missing', function(): void {
    $user = Mockery::mock(User::class);
    $provider = Mockery::mock(UserProvider::class)->makePartial();

    $result = $provider->validateCredentials($user, ['password' => null]);

    expect($result)->toBeFalse();
});
it('returns false if user salt is null', function(): void {
    $user = Mockery::mock(User::class)->makePartial();
    $user->salt = null;

    $provider = new UserProvider(['model' => User::class]);

    $result = $provider->hasShaPassword($user, ['password' => 'password']);

    expect($result)->toBeFalse();
});

it('returns true if user password matches SHA1 hash', function(): void {
    $user = Mockery::mock(User::class)->makePartial();
    $user->salt = 'random_salt';
    $user->shouldReceive('extendableGet')
        ->with('password')
        ->andReturn(sha1('random_salt'.sha1('random_salt'.sha1('password'))));

    $provider = new UserProvider(['model' => User::class]);

    $result = $provider->hasShaPassword($user, ['password' => 'password']);

    expect($result)->toBeTrue();
});

it('returns false if user password does not match SHA1 hash', function(): void {
    $user = Mockery::mock(User::class)->makePartial();
    $user->salt = 'random_salt';
    $user->password = sha1('random_salt'.sha1('random_salt'.sha1('wrong_password')));

    $provider = new UserProvider(['model' => User::class]);

    $result = $provider->hasShaPassword($user, ['password' => 'password']);

    expect($result)->toBeFalse();
});

it('rehashes password if required', function(): void {
    $user = Mockery::mock(User::class);
    $provider = new UserProvider(['model' => User::class]);
    $user->shouldReceive('getAuthPassword')->andReturn('password');
    $user->shouldReceive('getAuthPasswordName')->andReturn('password');
    $user->shouldReceive('forceFill')->with(['password' => 'hashed_password'])->andReturnSelf()->once();
    $user->shouldReceive('save')->once();
    Hash::shouldReceive('needsRehash')->with('password')->andReturn(true)->once();
    Hash::shouldReceive('make')->with('password')->andReturn('hashed_password');

    $provider->rehashPasswordIfRequired($user, ['password' => 'password']);
});

it('does not rehashes password', function(): void {
    $user = Mockery::mock(User::class);
    $provider = new UserProvider(['model' => User::class]);
    $user->shouldReceive('getAuthPassword')->andReturn('password');
    Hash::shouldReceive('needsRehash')->with('password')->andReturn(false)->once();

    $provider->rehashPasswordIfRequired($user, ['password' => 'password']);
});

it('registers a new user', function(): void {
    $user = Mockery::mock(User::class);
    $provider = Mockery::mock(UserProvider::class)->makePartial()->shouldAllowMockingProtectedMethods();
    $provider->shouldReceive('createModel->register')->with(['email' => 'test@example.com'], true)->andReturn($user);

    $result = $provider->register(['email' => 'test@example.com'], true);

    expect($result)->toBe($user);
});
