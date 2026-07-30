<?php

declare(strict_types=1);

namespace Igniter\Coupons\Tests\Http\Controllers;

it('loads coupon redemptions page', function(): void {
    actingAsSuperUser()
        ->get(route('igniter.coupons.redemptions'))
        ->assertOk();
});
