<?php

declare(strict_types=1);

namespace Igniter\Api\Tests\Traits;

use Igniter\Api\Traits\AuthorizesRequest;
use Igniter\User\Models\User;
use Illuminate\Auth\AuthManager;
use Mockery;

it('returns the current access token of the authenticated user', function(): void {
    $traitObject = new class
    {
        use AuthorizesRequest;

        public function testToken()
        {
            return $this->token();
        }
    };
    $user = Mockery::mock(User::class);
    $user->shouldReceive('currentAccessToken')->andReturn('accessToken');
    request()->setUserResolver(fn() => $user);

    $result = $traitObject->testToken();

    expect($result)->toBe('accessToken');
});

it('returns the authenticated user', function(): void {
    $traitObject = new class
    {
        use AuthorizesRequest;

        public function testUser()
        {
            return $this->user();
        }
    };
    $user = Mockery::mock(User::class);
    request()->setUserResolver(fn() => $user);

    $result = $traitObject->testUser();

    expect($result)->toBe($user);
});

it('returns the auth instance', function(): void {
    $traitObject = new class
    {
        use AuthorizesRequest;

        public function testAuth()
        {
            return $this->auth();
        }
    };
    $auth = Mockery::mock(AuthManager::class);
    app()->instance('auth', $auth);

    $result = $traitObject->testAuth();

    expect($result)->toBe($auth);
});

it('returns the token using getToken method', function(): void {
    $traitObject = new class
    {
        use AuthorizesRequest;

        public function testGetToken()
        {
            return $this->getToken();
        }
    };
    $user = Mockery::mock(User::class);
    $user->shouldReceive('currentAccessToken')->andReturn('accessToken');
    request()->setUserResolver(fn() => $user);

    $result = $traitObject->testGetToken();

    expect($result)->toBe('accessToken');
});

it('checks if the token has the given ability', function(): void {
    $traitObject = new class
    {
        use AuthorizesRequest;

        public function testTokenCan()
        {
            return $this->tokenCan();
        }
    };
    $user = Mockery::mock(User::class);
    $user->shouldReceive('tokenCan')->with('*')->andReturn(true);
    request()->setUserResolver(fn() => $user);

    $result = $traitObject->testTokenCan();

    expect($result)->toBeTrue();
});
