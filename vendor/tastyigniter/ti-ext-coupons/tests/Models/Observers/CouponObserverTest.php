<?php

declare(strict_types=1);

namespace Igniter\Coupons\Tests\Models\Observers;

use Igniter\Cart\Models\Category;
use Igniter\Cart\Models\Menu;
use Igniter\Coupons\Models\Coupon;
use Igniter\Coupons\Models\Observers\CouponObserver;

it('detaches menus & categories when coupon is deleted', function(): void {
    $coupon = Coupon::factory()->create();
    $coupon->menus()->attach(Menu::factory()->create());
    $coupon->categories()->attach(Category::factory()->create());

    expect($coupon->menus()->count())->toBe(1)
        ->and($coupon->categories()->count())->toBe(1);

    (new CouponObserver)->deleting($coupon);

    expect($coupon->categories()->count())->toBe(0)
        ->and($coupon->menus()->count())->toBe(0);
});
