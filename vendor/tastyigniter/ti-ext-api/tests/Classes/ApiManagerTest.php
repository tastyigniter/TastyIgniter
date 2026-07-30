<?php

declare(strict_types=1);

namespace Igniter\Api\Tests\Classes;

use Igniter\Api\Classes\ApiManager;
use Igniter\Api\Tests\Fixtures\TestResource;
use Igniter\Flame\Support\Facades\Igniter;
use Illuminate\Routing\Router;
use Illuminate\Routing\RouteRegistrar;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Mockery;

beforeEach(function(): void {
    $this->apiManager = new ApiManager;
});

it('returns resources when they are loaded', function(): void {
    expect($this->apiManager->getResources()->count())->toBeGreaterThan(10);
});

it('returns empty array when resource is not found', function(): void {
    $resource = $this->apiManager->getResource('non-existent-endpoint');

    expect($resource)->toBe([]);
});

it('returns current resource based on route name', function(): void {
    Route::shouldReceive('currentRouteName')->andReturn('api.categories.index');

    $currentResource = $this->apiManager->getCurrentResource();

    expect($currentResource->endpoint)->toBe('categories');
});

it('returns current action based on route action', function(): void {
    Route::shouldReceive('currentRouteAction')->andReturn('TestController@index');

    $currentAction = $this->apiManager->getCurrentAction();

    expect($currentAction)->toBe('index');
});

it('registers routes when database and table exist', function(): void {
    $router = Mockery::mock(Router::class);
    $routerRegister = Mockery::mock(RouteRegistrar::class);
    Route::shouldReceive('middleware')->andReturn($routerRegister);
    $routerRegister->shouldReceive('as')->andReturnSelf();
    $routerRegister->shouldReceive('prefix')->with('api')->andReturnSelf();
    $routerRegister->shouldReceive('group')->andReturnUsing(function($callback) use ($router): true {
        $callback($router);

        return true;
    });
    $resourceObj = (object)[
        'controller' => TestResource::class,
        'options' => [],
    ];
    $apiManager = Mockery::mock(ApiManager::class)->makePartial();
    $apiManager->shouldReceive('getResources')->andReturn(['endpoint' => $resourceObj]);
    app()->instance(ApiManager::class, $apiManager);

    $router->shouldReceive('resource')->with('endpoint', TestResource::class, [])->once();

    ApiManager::registerRoutes();
});

it('does not register routes when database does not exist', function(): void {
    Igniter::shouldReceive('hasDatabase')->andReturnFalse();
    Schema::shouldReceive('hasTable')->with('igniter_api_resources')->never();
    Route::shouldReceive('middleware')->never();

    ApiManager::registerRoutes();
});

it('does not register routes when table does not exist', function(): void {
    Igniter::shouldReceive('hasDatabase')->andReturnTrue();
    Schema::shouldReceive('hasTable')->with('igniter_api_resources')->andReturn(false);
    Route::shouldReceive('middleware')->never();

    ApiManager::registerRoutes();
});

it('skips invalid controllers when registering routes', function(): void {
    $router = Mockery::mock(Router::class);
    $routerRegister = Mockery::mock(RouteRegistrar::class);
    Route::shouldReceive('middleware')->andReturn($routerRegister);
    $routerRegister->shouldReceive('as')->andReturnSelf();
    $routerRegister->shouldReceive('prefix')->with('api')->andReturnSelf();
    $routerRegister->shouldReceive('group')->andReturnUsing(function($callback) use ($router): true {
        $callback($router);

        return true;
    });
    $resourceObj = (object)[
        'controller' => 'InvalidController',
        'options' => [],
    ];
    $apiManager = Mockery::mock(ApiManager::class)->makePartial();
    $apiManager->shouldReceive('getResources')->andReturn(['endpoint' => $resourceObj]);
    app()->instance(ApiManager::class, $apiManager);

    $router->shouldReceive('resource')->never();

    ApiManager::registerRoutes();
});
