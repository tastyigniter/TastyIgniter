<?php

declare(strict_types=1);

namespace Igniter\Coupons\Models\Observers;

use Igniter\Coupons\Models\Coupon;

class CouponObserver
{
    public function deleting(Coupon $coupon): void
    {
        $coupon->categories()->detach();
        $coupon->menus()->detach();
    }
}
