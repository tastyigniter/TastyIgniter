<?php

declare(strict_types=1);

namespace Igniter\Api\Tests\Http\Middleware;

use Igniter\Api\Exceptions\AuthenticationException;
use Igniter\Api\Http\Middleware\Authenticate;
use Illuminate\Auth\AuthenticationException as IlluminateAuthenticationException;
use Illuminate\Http\Request;
use Mockery;

beforeEach(function(): void {
    $this->middleware = Mockery::mock(Authenticate::class)
        ->makePartial()
        ->shouldAllowMockingProtectedMethods();
    $this->request = Mockery::mock(Request::class);
    $this->next = (fn($request): string => 'next');
});

it('handles request with default guard', function(): void {
    config()->set('igniter-api.guard');
    $this->middleware->shouldReceive('authenticate')->with($this->request, [])->andReturn(true);

    $response = $this->middleware->handle($this->request, $this->next);

    expect($response)->toBe('next');
});

it('handles request with custom guard', function(): void {
    config()->set('igniter-api.guard', 'api');
    $this->middleware->shouldReceive('authenticate')->with($this->request, ['api'])->andReturn(true);

    $response = $this->middleware->handle($this->request, $this->next);

    expect($response)->toBe('next');
});

it('throws custom authentication exception on failure', function(): void {
    config()->set('igniter-api.guard', 'api');
    $this->middleware->shouldReceive('authenticate')
        ->with($this->request, ['api'])
        ->andThrow(new IlluminateAuthenticationException('Unauthenticated.', ['api']));

    $this->expectException(AuthenticationException::class);
    $this->expectExceptionMessage('Unauthenticated.');

    $this->middleware->handle($this->request, $this->next);
});
