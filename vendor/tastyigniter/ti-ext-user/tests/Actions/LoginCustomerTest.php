<?php

declare(strict_types=1);

namespace Igniter\User\Tests\Actions;

use Igniter\Flame\Exception\FlashException;
use Igniter\User\Actions\LoginCustomer;
use Igniter\User\Facades\Auth;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Session;

it('fires beforeAuthenticate event with correct parameters', function(): void {
    Event::fake();
    $credentials = ['email' => 'user@example.com', 'password' => 'password'];
    Auth::shouldReceive('check')->andReturnFalse();
    Auth::shouldReceive('attempt')->andReturnTrue();
    Session::shouldReceive('regenerate')->once();

    $loginUser = new LoginCustomer($credentials);
    $loginUser->handle();

    Event::assertDispatched('igniter.user.beforeAuthenticate', fn($eventName, $eventPayload): bool => $eventPayload[0] === $loginUser && $eventPayload[1] === $credentials);

    Event::assertDispatched('igniter.user.login', fn($eventName, $eventPayload): bool => $eventPayload[0] === $loginUser);
});

it('throws FlashException when authentication fails', function(): void {
    $credentials = ['email' => 'user@example.com', 'password' => 'wrongpassword'];
    Auth::shouldReceive('check')->andReturnFalse();
    Auth::shouldReceive('attempt')->andReturn(false);

    expect(fn() => (new LoginCustomer($credentials))->handle())->toThrow(FlashException::class);
});
