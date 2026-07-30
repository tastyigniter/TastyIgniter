<?php

declare(strict_types=1);

namespace Igniter\Cart\Tests\Models;

use Igniter\Cart\Models\Order;
use Igniter\Cart\Models\Stock;
use Igniter\Cart\Models\StockHistory;
use Igniter\User\Models\User;

it('creates stock history correctly', function(): void {
    $stock = Stock::factory()->create();
    $user = User::factory()->create();
    $order = Order::factory()->create();

    $stockHistory = StockHistory::createHistory($stock, 5, Stock::STATE_SOLD, [
        'user_id' => $user->id,
        'order_id' => $order->id,
    ]);

    expect($stockHistory->stock_id)->toBe($stock->id)
        ->and($stockHistory->user_id)->toBe($user->id)
        ->and($stockHistory->order_id)->toBe($order->id)
        ->and($stockHistory->quantity)->toBe(5)
        ->and($stockHistory->state)->toBe(Stock::STATE_SOLD);
});

it('gets staff name attribute correctly', function(): void {
    $user = User::factory()->create([
        'name' => 'John Doe',
    ]);

    $stockHistory = StockHistory::factory()->create([
        'user_id' => $user->getKey(),
    ]);

    expect($stockHistory->staff_name)->toBe('John Doe');
});

it('gets state text attribute correctly', function(): void {
    $stockHistory = StockHistory::factory()->create([
        'state' => Stock::STATE_SOLD,
    ]);

    expect($stockHistory->state_text)->toBe(lang('igniter.cart::default.stocks.text_action_sold'));
});

it('gets created at since attribute correctly', function(): void {
    $stockHistory = StockHistory::factory()->create([
        'created_at' => now()->subHour(),
    ]);

    expect($stockHistory->created_at_since)->toBe('1 hour ago');
});

it('configures stock history model correctly', function(): void {
    $stockHistory = new StockHistory;
    expect($stockHistory->getTable())->toBe('stock_history')
        ->and($stockHistory->getKeyName())->toBe('id')
        ->and($stockHistory->getGuarded())->toBe([])
        ->and($stockHistory->getAppends())->toBe([
            'staff_name', 'state_text', 'created_at_since',
        ])
        ->and($stockHistory->getMorphClass())->toBe('stock_history');
});
