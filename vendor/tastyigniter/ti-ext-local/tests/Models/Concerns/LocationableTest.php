<?php

declare(strict_types=1);

namespace Igniter\Local\Tests\Models\Concerns;

use Igniter\Cart\Models\Menu;
use Igniter\Cart\Models\Order;
use Igniter\Flame\Exception\FlashException;
use Igniter\Local\Models\Location;
use Igniter\Local\Models\Review;
use Igniter\User\Facades\AdminAuth;
use Illuminate\Http\Request;

it('detaches locations on delete for morph relation type', function(): void {
    $menu = Menu::factory()->create();
    $menu->locations()->attach(Location::factory()->create());

    $menu->delete();

    expect($menu->locations()->count())->toBe(0);
});

it('throws exception when detaching locations as non-superuser', function(): void {
    $menu = Menu::factory()->create();
    $menu->locations()->attach(Location::factory()->create());
    AdminAuth::shouldReceive('isSuperUser')->andReturnFalse();
    $request = mock(Request::class);
    $request->shouldReceive('setUserResolver')->andReturnNull();
    $request->shouldReceive('getScheme')->andReturn('https');
    $request->shouldReceive('root')->andReturn('localhost');
    $request->shouldReceive('route')->andReturnNull();
    $request->shouldReceive('path')->andReturn('admin/menus/edit/1');
    app()->instance('request', $request);

    $this->expectException(FlashException::class);
    $this->expectExceptionMessage(lang('igniter::admin.alert_warning_locationable_delete'));

    $menu->delete();
});

it('checks if locationable relation is single type', function(): void {
    $order = Order::factory()->create();

    expect($order->locationableIsSingleRelationType())->toBeTrue();
});

it('checks if locationable relation is morph type', function(): void {
    $menu = Menu::factory()->create();

    expect($menu->locationableIsMorphRelationType())->toBeTrue();
});

it('checks if locationable relation exists for single relation type', function(): void {
    $review = Review::factory()->create(['location_id' => null]);
    expect($review->locationableRelationExists())->toBeFalse();

    $order = Order::factory()->create();
    $order->location()->associate(Location::factory()->create());

    expect($order->locationableRelationExists())->toBeTrue();
});

it('checks if locationable relation exists for morph relation type', function(): void {
    $menu = Menu::factory()->create();
    expect($menu->locationableRelationExists())->toBeFalse();

    $menu = Menu::factory()->create();
    $menu->locations()->attach(Location::factory()->create());

    expect($menu->locationableRelationExists())->toBeTrue();
});
