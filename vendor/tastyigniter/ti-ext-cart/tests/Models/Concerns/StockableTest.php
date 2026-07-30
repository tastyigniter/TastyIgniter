<?php

declare(strict_types=1);

namespace Igniter\Cart\Tests\Models\Concerns;

use Igniter\Cart\Models\Menu;
use Igniter\Cart\Models\Stock;
use Igniter\Local\Models\Location;

it('calculates stock quantity correctly', function(): void {
    $model = getModelWithStocks([5, 10, 15]);

    expect($model->stock_qty)->toBe(30);
});

it('filters trackable stocks correctly', function(): void {
    $model = getModelWithStocks([5, 10, 15], [true, false, true]);

    expect($model->getTrackableStocks())->toHaveCount(2);
});

it('gets all available stocks', function(): void {
    $model = getModelWithStocks([5, 10, 15]);

    expect($model->getAvailableStocks())->toHaveCount(3);
});

it('returns false when stocks are available', function(): void {
    $model = getModelWithStocks([5, 10, 15]);

    expect($model->outOfStock())->toBeFalse();
});

it('returns true when no stocks are available', function(): void {
    $model = getModelWithStocks([0, 0, 0]);

    expect($model->outOfStock())->toBeTrue();
});

it('returns true when enough stock is available', function(): void {
    $model = getModelWithStocks([5, 10, 15]);

    expect($model->checkStockLevel(20))->toBeTrue();
});

it('returns false when not enough stock is available', function(): void {
    $model = getModelWithStocks([5, 10, 15]);

    expect($model->checkStockLevel(50))->toBeFalse();
});

function getModelWithStocks(array $quantities, array $isTracked = [])
{
    $location = Location::factory()->create();
    $secondLocation = Location::factory()->create();
    $thirdLocation = Location::factory()->create();

    $menu = Menu::factory()
        ->hasAttached([$location, $secondLocation, $thirdLocation])
        ->create();

    Stock::factory()
        ->for($location)
        ->for($menu, 'stockable')
        ->create(['quantity' => $quantities[0], 'is_tracked' => $isTracked[0] ?? true]);

    Stock::factory()
        ->for($secondLocation)
        ->for($menu, 'stockable')
        ->create(['quantity' => $quantities[1], 'is_tracked' => $isTracked[1] ?? true]);

    Stock::factory()
        ->for($thirdLocation)
        ->for($menu, 'stockable')
        ->create(['quantity' => $quantities[2], 'is_tracked' => $isTracked[2] ?? true]);

    return $menu;
}
