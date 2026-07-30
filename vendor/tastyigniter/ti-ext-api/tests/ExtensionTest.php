<?php

declare(strict_types=1);

namespace Igniter\Api\Tests;

use Igniter\Api\Extension;
use Igniter\Api\Models\Resource;
use Igniter\User\Models\Customer;
use Igniter\User\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use League\Fractal\Serializer\JsonApiSerializer;
use Mockery;

it('loads registered api resources', function(): void {
    $resources = (new Resource)->listRegisteredResources();

    expect($resources)
        ->toHaveKey('categories')
        ->toHaveKey('currencies')
        ->toHaveKey('customers')
        ->toHaveKey('locations')
        ->toHaveKey('menus')
        ->toHaveKey('menu_options')
        ->toHaveKey('menu_item_options')
        ->toHaveKey('orders')
        ->toHaveKey('reservations')
        ->toHaveKey('reviews')
        ->toHaveKey('tables');
});

it('returns an array with the correct permission structure', function(): void {
    $result = (new Extension(app()))->registerPermissions();

    expect($result)->toBe([
        'Igniter.Api.Manage' => [
            'description' => 'Create, modify and delete api resources',
            'group' => 'igniter::system.permissions.name',
        ],
    ]);
});

it('returns the correct default serializer', function(): void {
    expect(config('fractal.default_serializer'))->toBe(JsonApiSerializer::class);
});

it('creates access token using http', function($email, $isAdmin, $deviceName, $abilities): void {
    $attributes = [
        'email' => $email,
        'status' => 1,
        'is_activated' => 1,
    ];

    $isAdmin
        ? User::factory()->create($attributes)
        : Customer::factory()->create($attributes);

    $response = $this->postJson('/api/token', [
        'email' => $email,
        'password' => 'password',
        'is_admin' => $isAdmin,
        'device_name' => $deviceName,
        'abilities' => $abilities,
    ]);

    $response->assertStatus(201);
    $response->assertJsonStructure(['status_code', 'token']);
})->with([
    ['admin@domain.tld', true, 'Test Device', ['*']],
    ['customer@domain.tld', false, 'Test Device', ['*']],
]);

it('creates access token using console command', function($email, $isAdmin, $deviceName, $abilities): void {
    $attributes = [
        'email' => $email,
        'status' => 1,
        'is_activated' => 1,
    ];

    $isAdmin
        ? User::factory()->create($attributes)
        : Customer::factory()->create($attributes);

    $this->artisan('igniter:api-token', [
        '--name' => $deviceName,
        '--email' => $email,
        '--admin' => $isAdmin,
        '--abilities' => $abilities,
    ])->assertExitCode(0);
})->with([
    ['admin@domain.tld', true, 'Test Device', ['*']],
    ['customer@domain.tld', false, 'Test Device', ['*']],
]);

it('configures rate limiting with user id', function(): void {
    $request = Mockery::mock(Request::class);
    $request->shouldReceive('user')->andReturn((object)['id' => 1]);
    $request->shouldReceive('ip')->andReturn('127.0.0.1');

    RateLimiter::shouldReceive('for')->with('api', Mockery::on(function($callback) use ($request): true {
        $callback($request);

        return true;
    }))->andReturnSelf()->once();

    (new Extension(app()))->boot();
});
