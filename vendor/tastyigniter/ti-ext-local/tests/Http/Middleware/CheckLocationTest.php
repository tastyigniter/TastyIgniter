<?php

declare(strict_types=1);

namespace Igniter\Local\Tests\Http\Middleware;

use Igniter\Local\Facades\Location;
use Igniter\Local\Http\Middleware\CheckLocation;
use Igniter\Local\Models\Location as LocationModel;
use Igniter\User\Facades\AdminAuth;
use Igniter\User\Models\User;
use Illuminate\Support\Facades\Route;

it('handles request correctly', function(): void {
    Route::get('test-route/{location}', fn(): string => 'ok')->middleware(CheckLocation::class);

    $location = LocationModel::factory()->create([
        'permalink_slug' => 'test-location',
    ]);

    Location::shouldReceive('currentOrDefault')->andReturn($location);

    $this->get('test-route/test-location')->assertStatus(200);

    expect(request()->route('location'))->toBe($location->permalink_slug);
});

it('handles admin request correctly', function(): void {
    Route::get('admin/test-route/{location}', fn(): string => 'ok')->middleware(CheckLocation::class);

    $location = LocationModel::factory()->create([
        'permalink_slug' => 'test-location',
    ]);

    Location::shouldReceive('currentOrDefault')->andReturn($location);

    $this->get('admin/test-route/test-location')->assertStatus(200);

    expect(request()->route('location'))->toBe($location->permalink_slug);
});

it('redirects when location route parameter does not match current location slug', function(): void {
    Route::get('test-route/{location}', fn(): string => 'ok')->middleware(CheckLocation::class);

    $location = LocationModel::factory()->create([
        'permalink_slug' => 'test-location',
    ]);

    Location::shouldReceive('currentOrDefault')->andReturn($location);

    $this->get('test-route/wrong-location')
        ->assertStatus(302)
        ->assertRedirect(page_url('home'));
});

it('redirects when location is disabled and admin does not have permission', function(): void {
    Route::get('test-route/{location}', fn(): string => 'ok')->middleware(CheckLocation::class);

    $location = LocationModel::factory()->create([
        'permalink_slug' => 'test-location',
        'location_status' => 0,
    ]);

    Location::shouldReceive('currentOrDefault')->andReturn($location);
    AdminAuth::shouldReceive('getUser->hasPermission')->andReturn(false);

    $this->get('test-route/test-location')
        ->assertStatus(302)
        ->assertRedirect(page_url('home'));
});

it('checks admin location correctly', function(): void {
    Route::get('admin/test-route', fn(): string => 'ok')->middleware(CheckLocation::class);

    $user = User::factory()->superUser()->create();
    $location = LocationModel::factory()->create([
        'permalink_slug' => 'test-location',
    ]);

    AdminAuth::shouldReceive('check')->andReturn(true);
    Location::shouldReceive('resetSession')->andReturnNull();
    Location::shouldReceive('current')->andReturn($location);
    AdminAuth::shouldReceive('user')->andReturn($user);

    $this->get('admin/test-route');

    expect(request()->route('location'))->toBe($location->permalink_slug);
});

it('checks admin location fails when user not assigned to location', function(): void {
    Route::get('admin/test-route', fn(): string => 'ok')->middleware(CheckLocation::class);

    $user = User::factory()->create();
    $location = LocationModel::factory()->create([
        'permalink_slug' => 'test-location',
    ]);

    AdminAuth::shouldReceive('check')->andReturn(true);
    Location::shouldReceive('resetSession')->andReturnNull();
    Location::shouldReceive('current')->andReturn($location);
    AdminAuth::shouldReceive('user')->andReturn($user);

    $this->get('admin/test-route');

    expect(request()->route('location'))->toBeNull();
});
