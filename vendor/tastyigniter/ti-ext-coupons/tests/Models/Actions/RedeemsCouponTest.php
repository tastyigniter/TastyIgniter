<?php

declare(strict_types=1);

namespace Igniter\Cart\Tests\Models\Actions;

use Igniter\Cart\Models\Order;
use Igniter\Coupons\Models\Actions\RedeemsCoupon;
use Igniter\Coupons\Models\Coupon as CouponModel;
use Igniter\Coupons\Models\CouponHistory;
use Illuminate\Support\Facades\Event;

it('redeems coupon returns null when no coupon order total', function(): void {
    $order = Order::factory()->create();

    expect((new RedeemsCoupon($order))->redeemCoupon())->toBeNull();
});

it('redeems coupon correctly', function(): void {
    Event::fake();

    $order = Order::factory()->create();
    $order->totals()->create([
        'code' => 'coupon',
        'title' => 'Coupon (test-coupon)',
        'value' => 10,
        'priority' => 1,
    ]);
    $couponHistory = CouponHistory::create([
        'order_id' => $order->order_id,
        'coupon_id' => 1,
        'code' => 'test-coupon',
        'amount' => 10,
        'min_total' => 0,
    ]);

    (new RedeemsCoupon($order))->redeemCoupon();

    expect($couponHistory->fresh()->status)->toBeTrue();

    Event::assertDispatched('admin.order.couponRedeemed');
});

it('logs coupon history correctly', function(): void {
    Event::fake();

    $order = Order::factory()->create();
    $couponTotal = $order->totals()->create([
        'code' => 'coupon',
        'title' => 'Coupon [test-coupon]',
        'value' => 10,
        'priority' => 1,
    ]);
    CouponModel::factory()->create([
        'code' => 'test-coupon',
        'name' => 'coupon',
    ]);

    $redeemsCoupon = new RedeemsCoupon($order);
    expect($redeemsCoupon->logCouponHistory($couponTotal))->toBeInstanceOf(CouponHistory::class);

    Event::assertDispatched('couponHistory.beforeAddHistory');
});

it('fails log coupon history when order does not exists', function(): void {
    Event::fake();

    $order = Order::factory()->make(['exists' => false]);
    $coupon = CouponModel::factory()->create();
    $redeemsCoupon = new RedeemsCoupon($order);

    expect($redeemsCoupon->logCouponHistory(10))->toBeFalse();

    Event::assertNotDispatched('couponHistory.beforeAddHistory');
});
