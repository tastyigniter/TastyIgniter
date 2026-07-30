<?php

declare(strict_types=1);

namespace Igniter\User\Tests\Http\Middleware;

use Igniter\Flame\Support\Facades\Igniter;
use Igniter\User\Http\Middleware\Authenticate;

it('allows requests to proceed when no database is available', function(): void {
    Igniter::partialMock()->shouldReceive('hasDatabase')
        ->once()
        ->andReturnFalse();

    $request = request();

    $middleware = new Authenticate(auth());

    expect($middleware->handle($request, fn($request): string => 'next'))->toBe('next');
});
