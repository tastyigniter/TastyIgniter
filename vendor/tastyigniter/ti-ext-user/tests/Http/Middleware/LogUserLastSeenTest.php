<?php

declare(strict_types=1);

namespace Igniter\User\Tests\Http\Middleware;

use Igniter\User\Auth\CustomerGuard;
use Igniter\User\Http\Middleware\LogUserLastSeen;
use Igniter\User\Models\Customer;
use Illuminate\Http\Request;
use Mockery;

beforeEach(function(): void {
    $this->middleware = new LogUserLastSeen;
    $this->request = Mockery::mock(Request::class)->makePartial();
    app()->instance('request', $this->request);
    $this->next = fn($request): string => 'next';
});

it('logs user last seen when database is available and user is authenticated', function(): void {
    $authService = Mockery::mock(CustomerGuard::class);
    $authService->shouldReceive('check')->andReturnTrue();
    $authService->shouldReceive('getId')->andReturn(1);
    $authService->shouldReceive('user')->andReturn($customer = Mockery::mock(Customer::class)->makePartial());
    $customer->shouldReceive('updateLastSeen')->andReturnTrue()->atMost(2);
    app()->instance('admin.auth', $authService);
    app()->instance('main.auth', $authService);

    $response = $this->middleware->handle($this->request, $this->next);

    expect($response)->toBe('next');
});

it('does not log user last seen when user is not authenticated', function(): void {
    $authService = Mockery::mock(CustomerGuard::class);
    $authService->shouldReceive('check')->andReturnFalse();
    app()->instance('admin.auth', $authService);
    app()->instance('main.auth', $authService);

    $response = $this->middleware->handle($this->request, $this->next);

    expect($response)->toBe('next');
});
