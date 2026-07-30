<?php

declare(strict_types=1);

namespace Igniter\Api\Tests\Listeners;

use Igniter\Api\Classes\ApiManager;
use Igniter\Api\Listeners\TokenEventSubscriber;
use Igniter\Api\Models\Token;
use Igniter\User\Models\User;
use Illuminate\Routing\Route;
use Laravel\Sanctum\Events\TokenAuthenticated;
use Mockery;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

beforeEach(function(): void {
    $this->subscriber = new TokenEventSubscriber;
    $this->token = Token::factory()->create([
        'tokenable_type' => 'users',
        'tokenable_id' => User::factory()->create()->getKey(),
    ]);
    $this->event = new TokenAuthenticated($this->token);
    $this->route = Mockery::mock(Route::class);
    request()->setRouteResolver(fn() => $this->route);
});

function mockCurrentResource(array $authorization = []): void
{
    app()->instance(ApiManager::class, mock(ApiManager::class, function($mock) use ($authorization): void {
        $mock->shouldReceive('getCurrentResource')->andReturn((object)[
            'endpoint' => 'categories',
            'controller' => 'TestController',
            'options' => ['authorization' => $authorization],
        ]);
    }));
}

it('returns access token for allowed group all', function(): void {
    mockCurrentResource(['index' => 'all']);
    $this->route->shouldReceive('getActionMethod')->andReturn('index');

    $result = $this->subscriber->handleTokenAuthenticated($this->event);

    expect($result)->token->toBe($this->token->token);
});

it('throws unauthorized exception for missing access token', function(): void {
    mockCurrentResource(['store' => 'admin']);
    $this->route->shouldReceive('getActionMethod')->andReturn('store');

    $this->event->token = null;

    $this->expectException(UnauthorizedHttpException::class);
    $this->expectExceptionMessage(lang('igniter.api::default.alert_auth_failed'));

    $this->subscriber->handleTokenAuthenticated($this->event);
});

it('throws access denied exception for restricted group', function(): void {
    mockCurrentResource(['store' => 'admin']);
    $this->route->shouldReceive('getActionMethod')->andReturn('store');

    $this->event->token->tokenable_type = 'customers';

    $this->expectException(AccessDeniedHttpException::class);
    $this->expectExceptionMessage(lang('igniter.api::default.alert_auth_restricted'));

    $this->subscriber->handleTokenAuthenticated($this->event);
});

it('returns tokenable for guest authorization', function(): void {
    mockCurrentResource(['store' => 'guest']);
    $this->route->shouldReceive('getActionMethod')->andReturn('store');

    expect($this->subscriber->handleTokenAuthenticated($this->event))->toBeInstanceOf(User::class);
});

it('throws access denied exception for customer group', function(): void {
    mockCurrentResource(['store' => 'customer']);
    $this->route->shouldReceive('getActionMethod')->andReturn('store');

    $this->expectException(AccessDeniedHttpException::class);
    $this->expectExceptionMessage(lang('igniter.api::default.alert_auth_restricted'));

    $this->subscriber->handleTokenAuthenticated($this->event);
});

it('returns tokenable for customer or admin (users) authorization', function(): void {
    mockCurrentResource(['store' => 'users']);
    $this->route->shouldReceive('getActionMethod')->andReturn('store');

    expect($this->subscriber->handleTokenAuthenticated($this->event))->toBeInstanceOf(User::class);
});

it('returns tokenable for valid access token', function(): void {
    mockCurrentResource(['store' => 'admin']);
    $this->route->shouldReceive('getActionMethod')->andReturn('store');

    $tokenable = $this->subscriber->handleTokenAuthenticated($this->event);

    expect($tokenable)->toBeInstanceOf(User::class);
});
