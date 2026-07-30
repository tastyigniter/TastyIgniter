<?php

declare(strict_types=1);

namespace Igniter\Cart\Tests\ApiResources;

use Igniter\Cart\Models\Category;
use Igniter\Cart\Models\Menu;
use Igniter\Coupons\Models\Coupon;
use Igniter\Coupons\Models\CouponHistory;
use Igniter\User\Models\User;
use Illuminate\Testing\Fluent\AssertableJson;
use Laravel\Sanctum\Sanctum;

it('returns all coupons', function(): void {
    Sanctum::actingAs(User::factory()->create(), ['coupons:*']);

    $this
        ->get(route('igniter.api.coupons.index'))
        ->assertOk()
        ->assertJsonPath('data.0.attributes.name', Coupon::first()->name);
});

it('returns all coupons with menus, categories and history', function(): void {
    $coupon = Coupon::first();
    $coupon->menus()->save(Menu::factory()->create());
    $coupon->categories()->save(Category::factory()->create());
    $coupon->history()->save(CouponHistory::create([
        'order_id' => 1,
        'coupon_id' => 1,
        'code' => 'test-coupon',
        'amount' => 10,
        'min_total' => 0,
    ]));

    Sanctum::actingAs(User::factory()->create(), ['coupons:*']);

    $this
        ->get(route('igniter.api.coupons.index', ['include' => [
            'menus', 'categories', 'history',
        ]]))
        ->assertOk()
        ->assertJsonPath('data.0.attributes.name', $coupon->name)
        ->assertJsonPath('data.0.relationships.menus.data.0.id', (string)$coupon->menus->first()->getKey())
        ->assertJsonPath('data.0.relationships.categories.data.0.id', (string)$coupon->categories->first()->getKey())
        ->assertJsonPath('data.0.relationships.history.data.0.id', (string)$coupon->history->first()->getKey());
});

it('shows a coupon', function(): void {
    Sanctum::actingAs(User::factory()->create(), ['coupons:*']);
    $coupon = Coupon::first();

    $this
        ->get(route('igniter.api.coupons.show', [$coupon->getKey()]))
        ->assertOk()
        ->assertJson(fn(AssertableJson $json): AssertableJson => $json
            ->has('data.attributes', fn(AssertableJson $json): AssertableJson => $json
                ->where('name', $coupon->name)
                ->where('code', $coupon->code)
                ->etc()
            )->etc()
        );
});

it('creates a coupon', function(): void {
    Sanctum::actingAs(User::factory()->create(), ['coupons:*']);

    $this
        ->post(route('igniter.api.coupons.store'), [
            'name' => 'Test coupon',
            'code' => 'TESTCOUPON',
            'type' => 'P',
            'discount' => 10,
            'redemptions' => 10,
            'customer_redemptions' => 1,
            'validity' => 'forever',
        ])
        ->assertCreated()
        ->assertJson(fn(AssertableJson $json): AssertableJson => $json
            ->has('data.attributes', fn(AssertableJson $json): AssertableJson => $json
                ->where('name', 'Test coupon')
                ->where('code', 'TESTCOUPON')
                ->where('type', 'P')
                ->where('discount', 10)
                ->where('redemptions', 10)
                ->where('customer_redemptions', 1)
                ->etc()
            ));
});

it('updates a coupon', function(): void {
    Sanctum::actingAs(User::factory()->create(), ['coupons:*']);
    $coupon = Coupon::first();

    $this
        ->put(route('igniter.api.coupons.update', [$coupon->getKey()]), [
            'name' => 'Test coupon',
            'code' => 'TESTCOUPON',
            'type' => 'P',
            'discount' => 10,
            'redemptions' => 10,
            'customer_redemptions' => 1,
            'validity' => 'forever',
        ])
        ->assertOk();

    expect($coupon->fresh())->name->toBe('Test coupon')
        ->code->toBe('TESTCOUPON')
        ->type->toBe('P')
        ->discount->toBe(10.0)
        ->redemptions->toBe(10)
        ->customer_redemptions->toBe(1)
        ->validity->toBe('forever');
});

it('deletes a coupon', function(): void {
    Sanctum::actingAs(User::factory()->create(), ['coupons:*']);
    $coupon = Coupon::first();

    $this
        ->delete(route('igniter.api.coupons.destroy', [$coupon->getKey()]))
        ->assertStatus(204);

    expect(Coupon::find($coupon->getKey()))->toBeNull();
});
