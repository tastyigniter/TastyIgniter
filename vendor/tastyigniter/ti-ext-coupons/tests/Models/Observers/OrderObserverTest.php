<?php

declare(strict_types=1);

namespace Igniter\Coupons\Tests\Models\Observers;

use Igniter\Cart\Models\Order;
use Igniter\Coupons\Models\Observers\OrderObserver;

it('deletes coupon history when order is deleted', function(): void {
    $order = Order::factory()->create();
    $order->coupon_history()->create([
        'coupon_id' => 1,
        'code' => 'test-coupon',
        'amount' => 10,
        'min_total' => 0,
    ]);

    expect($order->coupon_history()->count())->toBe(1);

    (new OrderObserver)->deleting($order);

    expect($order->coupon_history()->count())->toBe(0);
});
