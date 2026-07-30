<?php

declare(strict_types=1);

namespace Igniter\Coupons\Tests\Http\Controllers;

use Igniter\Coupons\Models\Coupon;

it('loads coupons page', function(): void {
    actingAsSuperUser()
        ->get(route('igniter.coupons.coupons'))
        ->assertOk();
});

it('loads create coupon page', function(): void {
    actingAsSuperUser()
        ->get(route('igniter.coupons.coupons', ['slug' => 'create']))
        ->assertOk();
});

it('loads edit coupon page', function(): void {
    $coupon = Coupon::factory()->create();

    actingAsSuperUser()
        ->get(route('igniter.coupons.coupons', ['slug' => 'edit/'.$coupon->coupon_id]))
        ->assertOk();
});

it('loads coupon preview page', function(): void {
    $coupon = Coupon::factory()->create();

    actingAsSuperUser()
        ->get(route('igniter.coupons.coupons', 'preview/'.$coupon->coupon_id))
        ->assertOk();
});

it('creates coupon', function(): void {
    actingAsSuperUser()
        ->post(route('igniter.coupons.coupons', ['slug' => 'create']), [
            'Coupon' => [
                'name' => 'Created Coupon',
                'code' => 'created-coupon',
                'type' => 'P',
                'discount' => 10,
                'redemptions' => 10,
                'customer_redemptions' => 1,
                'validity' => 'forever',
            ],
        ], [
            'X-Requested-With' => 'XMLHttpRequest',
            'X-IGNITER-REQUEST-HANDLER' => 'onSave',
        ]);

    expect(Coupon::where('name', 'Created Coupon')->exists())->toBeTrue();
});

it('updates coupon', function(): void {
    $coupon = Coupon::factory()->create();

    actingAsSuperUser()
        ->post(route('igniter.coupons.coupons', ['slug' => 'edit/'.$coupon->coupon_id]), [
            'Coupon' => [
                'name' => 'Updated Coupon',
                'code' => 'updated-coupon',
                'type' => 'P',
                'discount' => 10,
                'redemptions' => 10,
                'customer_redemptions' => 1,
                'validity' => 'forever',
            ],
        ], [
            'X-Requested-With' => 'XMLHttpRequest',
            'X-IGNITER-REQUEST-HANDLER' => 'onSave',
        ]);

    expect(Coupon::where('name', 'Updated Coupon')->exists())->toBeTrue();
});

it('deletes coupon', function(): void {
    $coupon = Coupon::factory()->create();

    actingAsSuperUser()
        ->post(route('igniter.coupons.coupons', ['slug' => 'edit/'.$coupon->coupon_id]), [
            'coupon_id' => $coupon->coupon_id,
        ], [
            'X-Requested-With' => 'XMLHttpRequest',
            'X-IGNITER-REQUEST-HANDLER' => 'onDelete',
        ]);

    expect(Coupon::find($coupon->coupon_id))->toBeNull();
});
