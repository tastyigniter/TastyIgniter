<?php

declare(strict_types=1);

namespace Igniter\Cart\Tests\Models;

use Igniter\Cart\Models\Menu;
use Igniter\Cart\Models\Stock;
use Igniter\Flame\Database\Model;
use Igniter\Flame\Exception\ApplicationException;
use Igniter\Local\Models\Location;
use Igniter\System\Mail\AnonymousTemplateMailable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Mail;
use InvalidArgumentException;

it('applies stockable scope with correct model type and id', function(): void {
    $query = mock(Builder::class);
    $model = mock(Model::class)->makePartial();
    $model->shouldReceive('getMorphClass')->andReturn('TestModel');
    $model->shouldReceive('getKey')->andReturn(1);
    $query->shouldReceive('where')->with('stockable_type', 'TestModel')->andReturnSelf();
    $query->shouldReceive('where')->with('stockable_id', 1)->andReturnSelf();

    $result = (new Stock)->scopeApplyStockable($query, $model);

    expect($result)->toBe($query);
});

it('updates stock correctly', function(): void {
    Event::fake();
    Mail::fake();

    $menu = Menu::factory()->create();
    $stock = Stock::factory()->create([
        'stockable_id' => $menu->getKey(),
        'stockable_type' => $menu->getMorphClass(),
        'quantity' => 1,
        'is_tracked' => true,
        'low_stock_alert' => true,
        'low_stock_threshold' => 10,
    ]);

    $stock->updateStock(5, Stock::STATE_RESTOCK);

    expect($stock->quantity)->toBe(6);

    Event::assertDispatched('admin.stock.updated', function($event, $args) use ($stock): bool {
        [$updatedStock, $history, $stockQty] = $args;

        return $updatedStock->getKey() === $stock->getKey();
    });

    Mail::assertQueued(AnonymousTemplateMailable::class, fn($mailable): bool => $mailable->getTemplateCode() === 'igniter.cart::mail.low_stock_alert');
});

it('recounts stock correctly', function(): void {
    Event::fake();

    $menu = Menu::factory()->create();
    $stock = Stock::factory()->create([
        'stockable_id' => $menu->getKey(),
        'stockable_type' => $menu->getMorphClass(),
        'quantity' => 100,
        'low_stock_alert' => false,
        'low_stock_threshold' => 700,
    ]);

    $stock->updateStock(500, Stock::STATE_RECOUNT);

    expect($stock->quantity)->toBe(500);
});

it('does not update stock when not tracked', function(): void {
    Event::fake();

    $stock = Stock::factory()->create([
        'quantity' => 10,
        'is_tracked' => false,
    ]);

    $stock->updateStock(5, Stock::STATE_SOLD);

    expect($stock->quantity)->toBe(10);
    Event::assertNotDispatched('admin.stock.updated');
});

it('throws exception when marking untrackable as out of stock', function(): void {
    $stock = Stock::factory()->create([
        'quantity' => 10,
        'is_tracked' => false,
    ]);

    expect(fn() => $stock->markAsOutOfStock())->toThrow(sprintf(
        lang('igniter.cart::default.stocks.alert_stock_not_tracked'), $stock->stockable_name,
    ));
});

it('checks stock correctly', function(): void {
    $stock = Stock::factory()->create([
        'quantity' => 10,
        'is_tracked' => true,
    ]);

    expect($stock->checkStock(5))->toBeTrue()
        ->and($stock->checkStock(15))->toBeFalse();

    $stock->is_tracked = false;

    expect($stock->checkStock(5))->toBeTrue();
});

it('checks if stock is out of stock correctly', function(): void {
    $stock = Stock::factory()->create([
        'quantity' => 0,
        'is_tracked' => true,
    ]);

    expect($stock->outOfStock())->toBeTrue();
});

it('checks if stock has low stock correctly', function(): void {
    $stock = Stock::factory()->create([
        'quantity' => 5,
        'low_stock_threshold' => 10,
        'is_tracked' => true,
    ]);

    expect($stock->hasLowStock())->toBeTrue();
});

it('gets mail recipients correctly', function(): void {
    $location = Location::factory()->create();
    $stock = Stock::factory()->for($location)->create();

    $recipients = $stock->mailGetRecipients('location');

    expect($recipients)->toBe([[$location->location_email, $location->location_name]]);
});

it('gets mail data correctly', function(): void {
    $menu = Menu::factory()->create(['menu_name' => 'Test Stock']);
    $location = Location::factory()->create(['location_name' => 'Test Location']);
    $stock = Stock::factory()->for($location)->create([
        'stockable_id' => $menu->getKey(),
        'stockable_type' => $menu->getMorphClass(),
    ]);

    $mailData = $stock->mailGetData();

    expect($mailData['stock_name'])->toBe('Test Stock')
        ->and($mailData['location_name'])->toBe('Test Location');
});

it('configures stock model correctly', function(): void {
    $stock = new Stock;
    expect($stock->getTable())->toBe('stocks')
        ->and($stock->getKeyName())->toBe('id')
        ->and($stock->getGuarded())->toBe(['quantity'])
        ->and($stock->timestamps)->toBeTrue()
        ->and($stock->getMorphClass())->toBe('stocks');
});

it('detects out of stock override when set to indefinitely', function(): void {
    $stock = Stock::factory()->outOfStockIndefinitely()->create([
        'quantity' => 10,
    ]);

    expect($stock->hasOutOfStockOverride())->toBeTrue()
        ->and($stock->outOfStock())->toBeTrue()
        ->and($stock->checkStock(1))->toBeFalse();
});

it('detects out of stock override when set to future date', function(): void {
    $stock = Stock::factory()->outOfStockUntil(now()->addHours(2))->create([
        'quantity' => 10,
    ]);

    expect($stock->hasOutOfStockOverride())->toBeTrue()
        ->and($stock->outOfStock())->toBeTrue()
        ->and($stock->checkStock(1))->toBeFalse();
});

it('does not detect out of stock override when date has passed', function(): void {
    $stock = Stock::factory()->outOfStockUntil(now()->subHour())->create([
        'quantity' => 10,
    ]);

    expect($stock->hasOutOfStockOverride())->toBeFalse()
        ->and($stock->outOfStock())->toBeFalse()
        ->and($stock->checkStock(1))->toBeTrue();
});

it('does not detect out of stock override when type is null', function(): void {
    $stock = Stock::factory()->create([
        'quantity' => 10,
        'is_tracked' => true,
        'out_of_stock_type' => null,
        'out_of_stock_until' => null,
    ]);

    expect($stock->hasOutOfStockOverride())->toBeFalse();
});

it('marks out of stock override correctly', function(): void {
    Event::fake();

    $menu = Menu::factory()->create();
    $stock = Stock::factory()->create([
        'stockable_id' => $menu->getKey(),
        'stockable_type' => $menu->getMorphClass(),
        'quantity' => 10,
        'is_tracked' => true,
    ]);

    $stock->applyOutOfStockOverride(Stock::OOS_INDEFINITELY);

    expect($stock->fresh()->out_of_stock_type)->toBe(Stock::OOS_INDEFINITELY)
        ->and($stock->fresh()->out_of_stock_until)->toBeNull();

    Event::assertDispatched('admin.stock.outOfStock');
});

it('marks out of stock override with custom date correctly', function(): void {
    Event::fake();

    $until = now()->addHours(3);
    $menu = Menu::factory()->create();
    $stock = Stock::factory()->create([
        'stockable_id' => $menu->getKey(),
        'stockable_type' => $menu->getMorphClass(),
        'quantity' => 10,
        'is_tracked' => true,
    ]);

    $stock->applyOutOfStockOverride(Stock::OOS_CUSTOM, $until);

    $fresh = $stock->fresh();
    expect($fresh->out_of_stock_type)->toBe(Stock::OOS_CUSTOM)
        ->and($fresh->out_of_stock_until->toDateTimeString())->toBe($until->toDateTimeString());
});

it('treats custom out of stock override without until as indefinitely', function(): void {
    Event::fake();

    $menu = Menu::factory()->create();
    $stock = Stock::factory()->create([
        'stockable_id' => $menu->getKey(),
        'stockable_type' => $menu->getMorphClass(),
        'quantity' => 10,
        'is_tracked' => true,
    ]);

    $stock->applyOutOfStockOverride(Stock::OOS_CUSTOM, null);

    $fresh = $stock->fresh();
    expect($fresh->out_of_stock_type)->toBe(Stock::OOS_INDEFINITELY)
        ->and($fresh->out_of_stock_until)->toBeNull();

    Event::assertDispatched('admin.stock.outOfStock');
});

it('throws exception when marking override with invalid type', function(): void {
    $stock = Stock::factory()->create([
        'quantity' => 10,
        'is_tracked' => true,
    ]);

    expect(fn() => $stock->applyOutOfStockOverride('invalid_type'))->toThrow(InvalidArgumentException::class);
});

it('throws exception when marking override on untracked stock', function(): void {
    $stock = Stock::factory()->create([
        'quantity' => 10,
        'is_tracked' => false,
    ]);

    expect(fn() => $stock->applyOutOfStockOverride(Stock::OOS_INDEFINITELY))->toThrow(ApplicationException::class);
});

it('clears out of stock override correctly', function(): void {
    $stock = Stock::factory()->outOfStockIndefinitely()->create([
        'quantity' => 10,
    ]);

    expect($stock->hasOutOfStockOverride())->toBeTrue();

    $stock->clearOutOfStockOverride();

    $fresh = $stock->fresh();
    expect($fresh->out_of_stock_type)->toBeNull()
        ->and($fresh->out_of_stock_until)->toBeNull()
        ->and($fresh->hasOutOfStockOverride())->toBeFalse();
});

it('returns correct out of stock label for indefinitely', function(): void {
    $stock = Stock::factory()->outOfStockIndefinitely()->create();

    expect($stock->getOutOfStockLabel())->toBe(lang('igniter.cart::default.stocks.text_oos_indefinitely'));
});

it('returns correct out of stock label for custom date', function(): void {
    $until = now()->addHours(3);
    $stock = Stock::factory()->outOfStockUntil($until)->create();

    expect($stock->getOutOfStockLabel())->toBe(sprintf(
        lang('igniter.cart::default.stocks.text_oos_until'),
        $until->format('M j, g:i A'),
    ));
});

it('returns null out of stock label when no override', function(): void {
    $stock = Stock::factory()->create([
        'quantity' => 10,
        'is_tracked' => true,
    ]);

    expect($stock->getOutOfStockLabel())->toBeNull();
});

it('scopes expired overrides correctly', function(): void {
    $expired = Stock::factory()->outOfStockUntil(now()->subHour())->create();
    $active = Stock::factory()->outOfStockUntil(now()->addHour())->create();
    $indefinite = Stock::factory()->outOfStockIndefinitely()->create();

    $expiredIds = Stock::whereExpiredOverrides()->pluck('id')->all();

    expect($expiredIds)->toContain($expired->getKey())
        ->and($expiredIds)->not->toContain($active->getKey())
        ->and($expiredIds)->not->toContain($indefinite->getKey());
});

it('does not alter quantity when marking out of stock override', function(): void {
    $stock = Stock::factory()->create([
        'quantity' => 10,
        'is_tracked' => true,
    ]);

    $stock->applyOutOfStockOverride(Stock::OOS_INDEFINITELY);

    expect($stock->fresh()->quantity)->toBe(10);
});
