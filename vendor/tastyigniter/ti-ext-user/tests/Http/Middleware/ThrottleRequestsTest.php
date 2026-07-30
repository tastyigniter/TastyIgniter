<?php

declare(strict_types=1);

namespace Igniter\User\Tests\Http\Middleware;

use Igniter\User\Http\Middleware\ThrottleRequests;
use Illuminate\Cache\RateLimiter;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Event;
use Mockery;
use stdClass;

beforeEach(function(): void {
    $this->rateLimiter = Mockery::mock(RateLimiter::class);
    $this->rateLimiter->shouldReceive('tooManyAttempts')->andReturnTrue();
    $this->rateLimiter->shouldReceive('availableIn')->andReturn(1);
    $this->middleware = new ThrottleRequests($this->rateLimiter);
    $this->request = Mockery::mock(Request::class)->makePartial();
    $this->next = fn($request): string => 'next';
});

it('throttles request when shouldThrottleRequest returns true', function(): void {
    $expectedParams = new stdClass;
    $expectedParams->maxAttempts = 6;
    $expectedParams->decayMinutes = 1;
    $expectedParams->prefix = '';
    $request = request();
    $request->setRouteResolver(fn(): Route => new Route('GET', 'login', []));

    $request->headers->set('x-igniter-request-handler', 'index::onLogin');

    Event::listen('igniter.user.beforeThrottleRequest', function($request, $params) use ($expectedParams): true {
        expect($params)->toEqual($expectedParams);

        return true;
    });

    expect(fn() => $this->middleware->handle($request, $this->next))->toThrow(ThrottleRequestsException::class);
});

it('does not throttle request when shouldThrottleRequest returns false', function(): void {
    $expectedParams = new stdClass;
    $expectedParams->maxAttempts = 60;
    $expectedParams->decayMinutes = 1;
    $expectedParams->prefix = '';
    $request = request();
    $request->setRouteResolver(fn(): Route => new Route('GET', 'login', []));

    Event::listen('igniter.user.beforeThrottleRequest', function($request, $params) use ($expectedParams): false {
        expect($params)->toEqual($expectedParams);

        return false;
    });

    expect($this->middleware->handle($request, $this->next))->toBe('next');
});
