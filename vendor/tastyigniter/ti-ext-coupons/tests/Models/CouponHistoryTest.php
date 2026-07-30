<?php

declare(strict_types=1);

namespace Igniter\Cart\Tests\Models;

use Igniter\Cart\Models\Order;
use Igniter\Coupons\Models\Coupon;
use Igniter\Coupons\Models\CouponHistory;
use Igniter\Flame\Database\Factories\HasFactory;
use Igniter\System\Models\Concerns\Switchable;
use Igniter\User\Models\Concerns\HasCustomer;
use Igniter\User\Models\Customer;
use Illuminate\Support\Facades\Event;

it('redeem returns false when coupon history is not found', function(): void {
    expect(CouponHistory::redeem(123))->toBeFalse();
});

it('redeems coupon history successfully', function(): void {
    $order = Order::factory()->create();
    $coupon = Coupon::factory()->create(['code' => 'TESTCODE']);
    $couponHistory = CouponHistory::factory()->create([
        'order_id' => $order->getKey(),
        'coupon_id' => $coupon->getKey(),
        'code' => $coupon->code,
        'amount' => 10.0,
        'min_total' => 0.0,
    ]);

    expect(CouponHistory::redeem($order->order_id))->toBeTrue()
        ->and($couponHistory->fresh()->status)->toBeTrue();
});

it('gets customer name attribute correctly', function(): void {
    $customer = Customer::factory()->create(['first_name' => 'Jane', 'last_name' => 'Doe']);
    $couponHistory = CouponHistory::factory()->create([
        'customer_id' => $customer->getKey(),
    ]);

    expect($couponHistory->customer_name)->toBe('Jane Doe');
});

it('returns null if customer does not exist', function(): void {
    $couponHistory = CouponHistory::factory()->create(['customer_id' => 0]);

    expect($couponHistory->customer_name)->toBeNull();
});

it('applies redeemed scope', function(): void {
    $query = CouponHistory::query()->applyRedeemed();

    expect($query->toRawSql())->toContain('where `status` >= 1');
});

it('touches status correctly', function(): void {
    $couponHistory = CouponHistory::factory()->create(['status' => 0]);

    $couponHistory->touchStatus();

    expect($couponHistory->status)->toBeTrue();

    $couponHistory->touchStatus();
    expect($couponHistory->status)->toBeFalse();
});

it('creates coupon history correctly', function(): void {
    $order = Order::factory()->create();
    $coupon = Coupon::factory()->create(['code' => 'TESTCODE']);
    $couponTotal = (object)['code' => 'TESTCODE', 'title' => '[TESTCODE] Test Coupon', 'value' => 10.0];

    $couponHistory = CouponHistory::createHistory($couponTotal, $order);

    expect($couponHistory)->not->toBeFalse()
        ->and($couponHistory->order_id)->toBe($order->getKey())
        ->and($couponHistory->customer_id)->toBeNull()
        ->and($couponHistory->coupon_id)->toBe($coupon->getKey())
        ->and($couponHistory->code)->toBe($coupon->code)
        ->and($couponHistory->amount)->toBe($couponTotal->value)
        ->and($couponHistory->min_total)->toBe($coupon->min_total);
});

it('does not create coupon history if coupon does not exist', function(): void {
    $order = Order::factory()->create();
    $couponTotal = (object)['code' => 'TESTCODE', 'title' => '[TESTCODE] Test Coupon', 'value' => 10];

    $couponHistory = CouponHistory::createHistory($couponTotal, $order);

    expect($couponHistory)->toBeNull();
});

it('does not create coupon history if beforeAddHistory event fails', function(): void {
    $order = Order::factory()->create();
    $expectedCoupon = Coupon::factory()->create(['code' => 'TESTCODE']);
    $couponTotal = (object)[
        'code' => 'TESTCODE',
        'title' => '[TESTCODE] Test Coupon',
        'value' => 10.0,
    ];
    Event::listen('couponHistory.beforeAddHistory', fn($couponHistory, $couponTotal, $customer, $coupon): bool => $expectedCoupon->getKey() !== $coupon->getKey());

    $couponHistory = CouponHistory::createHistory($couponTotal, $order);

    expect($couponHistory)->toBeNull();
});

it('applies filters to query builder', function(): void {
    $query = CouponHistory::query()->applyFilters([
        'redeemed' => 1,
        'customer' => 1,
        'order_id' => 2,
        'sort' => 'created_at asc',
    ]);

    expect($query->toRawSql())
        ->toContain('`status` >= 1')
        ->toContain('and `igniter_coupons_history`.`customer_id` = 1')
        ->toContain('and `order_id` = 2');
});

it('configures coupon history model correctly', function(): void {
    $couponHistory = new CouponHistory;

    expect(class_uses_recursive($couponHistory))
        ->toContain(HasCustomer::class)
        ->toContain(HasFactory::class)
        ->toContain(Switchable::class)
        ->and($couponHistory->getTable())->toBe('igniter_coupons_history')
        ->and($couponHistory->getKeyName())->toBe('coupon_history_id')
        ->and($couponHistory->timestamps)->toBeTrue()
        ->and($couponHistory->getGuarded())->toBe([])
        ->and($couponHistory->getAppends())->toContain('customer_name')
        ->and($couponHistory->getCasts())->toBe([
            'coupon_history_id' => 'integer',
            'coupon_id' => 'integer',
            'order_id' => 'integer',
            'customer_id' => 'integer',
            'min_total' => 'float',
            'amount' => 'float',
            'status' => 'boolean',
        ])
        ->and($couponHistory->relation['belongsTo'])->toBe([
            'customer' => Customer::class,
            'order' => Order::class,
            'coupon' => Coupon::class,
        ]);
});
