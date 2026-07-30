<?php

declare(strict_types=1);

namespace Igniter\Cart\Tests\Http\Middleware;

use Igniter\Cart\CartContent;
use Igniter\Cart\Facades\Cart;
use Igniter\Cart\Http\Middleware\CartMiddleware;
use Igniter\Cart\Models\CartSettings;
use Igniter\Local\Facades\Location;
use Igniter\Local\Models\Location as LocationModel;
use Igniter\User\Facades\Auth;
use Igniter\User\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Mockery;

it('handles request with location', function(): void {
    $locationMock = Mockery::mock(LocationModel::class);
    Location::shouldReceive('current')->andReturn($locationMock);
    Location::shouldReceive('getId')->andReturn(1);
    Cart::shouldReceive('instance')->with('location-1');

    $middleware = new CartMiddleware;
    $response = $middleware->handle(new Request, fn(): true => true);

    expect($response)->toBeTrue();
});

it('handles request without location', function(): void {
    Location::shouldReceive('current')->andReturn(null);
    Cart::expects('instance')->never();

    $middleware = new CartMiddleware;
    $response = $middleware->handle(new Request, fn(): true => true);

    expect($response)->toBeTrue();
});

it('terminates with abandoned cart and authenticated user', function(): void {
    CartSettings::set('abandoned_cart', true);

    $userMock = Mockery::mock(User::class);
    $userMock->shouldReceive('getKey')->andReturn(1);
    Auth::shouldReceive('check')->andReturn(true);
    Cart::shouldReceive('content')->andReturn(new CartContent(['item']));
    Auth::shouldReceive('getUser')->andReturn($userMock);
    Cart::shouldReceive('store')->with(1);

    $middleware = new CartMiddleware;
    expect($middleware->terminate(new Request, new Response))->toBeNull();
});

it('terminates without abandoned cart', function(): void {
    CartSettings::set('abandoned_cart', false);
    Auth::expects('check')->never();
    Cart::expects('store')->never();

    $middleware = new CartMiddleware;
    expect($middleware->terminate(new Request, new Response))->toBeNull();
});

it('terminates with abandoned cart but unauthenticated user', function(): void {
    CartSettings::set('abandoned_cart', true);
    Auth::shouldReceive('check')->andReturn(false);
    Cart::expects('content')->never();

    $middleware = new CartMiddleware;
    expect($middleware->terminate(new Request, new Response))->toBeNull();
});

it('terminates with abandoned cart, authenticated user but empty cart', function(): void {
    CartSettings::set('abandoned_cart', true);
    Auth::shouldReceive('check')->andReturn(true);
    Cart::shouldReceive('content')->andReturn(new CartContent);
    Cart::expects('store')->never();

    $middleware = new CartMiddleware;
    expect($middleware->terminate(new Request, new Response))->toBeNull();
});
