<?php

declare(strict_types=1);

namespace Igniter\Coupons\Tests\Http\Requests;

use Igniter\Coupons\Http\Requests\CouponRequest;

it('returns correct attribute labels', function(): void {
    $request = new CouponRequest;

    $attributes = $request->attributes();

    expect($attributes)->toHaveKey('name', lang('admin::lang.label_name'))
        ->and($attributes)->toHaveKey('code', lang('igniter.coupons::default.label_code'))
        ->and($attributes)->toHaveKey('type', lang('admin::lang.label_type'))
        ->and($attributes)->toHaveKey('discount', lang('igniter.coupons::default.label_discount'))
        ->and($attributes)->toHaveKey('min_total', lang('igniter.coupons::default.label_min_total'))
        ->and($attributes)->toHaveKey('redemptions', lang('igniter.coupons::default.label_redemption'))
        ->and($attributes)->toHaveKey('customer_redemptions', lang('igniter.coupons::default.label_customer_redemption'))
        ->and($attributes)->toHaveKey('description', lang('admin::lang.label_description'))
        ->and($attributes)->toHaveKey('validity', lang('igniter.coupons::default.label_validity'))
        ->and($attributes)->toHaveKey('fixed_date', lang('igniter.coupons::default.label_fixed_date'))
        ->and($attributes)->toHaveKey('fixed_from_time', lang('igniter.coupons::default.label_fixed_from_time'))
        ->and($attributes)->toHaveKey('fixed_to_time', lang('igniter.coupons::default.label_fixed_to_time'))
        ->and($attributes)->toHaveKey('period_start_date', lang('igniter.coupons::default.label_period_start_date'))
        ->and($attributes)->toHaveKey('period_end_date', lang('igniter.coupons::default.label_period_end_date'))
        ->and($attributes)->toHaveKey('recurring_every', lang('igniter.coupons::default.label_recurring_every'))
        ->and($attributes)->toHaveKey('recurring_from_time', lang('igniter.coupons::default.label_recurring_from_time'))
        ->and($attributes)->toHaveKey('recurring_to_time', lang('igniter.coupons::default.label_recurring_to_time'))
        ->and($attributes)->toHaveKey('order_restriction.*', lang('igniter.coupons::default.label_order_restriction'))
        ->and($attributes)->toHaveKey('status', lang('admin::lang.label_status'))
        ->and($attributes)->toHaveKey('locations.*', lang('admin::lang.column_location'))
        ->and($attributes)->toHaveKey('apply_coupon_on', lang('igniter.coupons::default.label_cart_restriction'))
        ->and($attributes)->toHaveKey('categories', lang('igniter.coupons::default.label_categories'))
        ->and($attributes)->toHaveKey('menus', lang('igniter.coupons::default.label_menus'));
});

it('returns correct validation rules', function(): void {
    $request = new CouponRequest;

    $request->setRouteResolver(fn(): object => new class
    {
        public function parameter($key, $default = null): string
        {
            return 'coupon';
        }
    });

    $rules = $request->rules();

    expect($rules)->toHaveKey('name')
        ->and($rules)->toHaveKey('code')
        ->and($rules)->toHaveKey('type')
        ->and($rules)->toHaveKey('discount')
        ->and($rules)->toHaveKey('min_total')
        ->and($rules)->toHaveKey('redemptions')
        ->and($rules)->toHaveKey('customer_redemptions')
        ->and($rules)->toHaveKey('customers')
        ->and($rules)->toHaveKey('customer_groups')
        ->and($rules)->toHaveKey('customers.*')
        ->and($rules)->toHaveKey('customer_groups.*')
        ->and($rules)->toHaveKey('description')
        ->and($rules)->toHaveKey('validity')
        ->and($rules)->toHaveKey('fixed_date')
        ->and($rules)->toHaveKey('fixed_from_time')
        ->and($rules)->toHaveKey('fixed_to_time')
        ->and($rules)->toHaveKey('period_start_date')
        ->and($rules)->toHaveKey('period_end_date')
        ->and($rules)->toHaveKey('recurring_every')
        ->and($rules)->toHaveKey('recurring_from_time')
        ->and($rules)->toHaveKey('recurring_to_time')
        ->and($rules)->toHaveKey('order_restriction.*')
        ->and($rules)->toHaveKey('status')
        ->and($rules)->toHaveKey('locations.*')
        ->and($rules['name'])->toContain('required', 'between:2,128')
        ->and($rules['code'])->toContain('required', 'min:2', 'unique:igniter_coupons,code,coupon,coupon_id')
        ->and($rules['type'])->toContain('required', 'string', 'size:1', 'in:P,F')
        ->and($rules['discount'])->toContain('required', 'numeric', 'min:0')
        ->and($rules['min_total'])->toContain('numeric')
        ->and($rules['redemptions'])->toContain('required', 'integer')
        ->and($rules['customer_redemptions'])->toContain('required', 'integer')
        ->and($rules['customers'])->toContain('nullable', 'array')
        ->and($rules['customer_groups'])->toContain('nullable', 'array')
        ->and($rules['description'])->toContain('max:1028')
        ->and($rules['validity'])->toContain('required', 'in:forever,fixed,period,recurring')
        ->and($rules['fixed_date'])->toContain('nullable', 'required_if:validity,fixed', 'date')
        ->and($rules['fixed_from_time'])->toContain('nullable', 'required_if:validity,fixed', 'date_format:H:i')
        ->and($rules['fixed_to_time'])->toContain('nullable', 'required_if:validity,fixed', 'date_format:H:i')
        ->and($rules['period_start_date'])->toContain('nullable', 'required_if:validity,period', 'date')
        ->and($rules['period_end_date'])->toContain('nullable', 'required_if:validity,period', 'date')
        ->and($rules['recurring_every'])->toContain('nullable', 'required_if:validity,recurring')
        ->and($rules['recurring_from_time'])->toContain('nullable', 'required_if:validity,recurring', 'date_format:H:i')
        ->and($rules['recurring_to_time'])->toContain('nullable', 'required_if:validity,recurring', 'date_format:H:i')
        ->and($rules['order_restriction.*'])->toContain('nullable', 'string')
        ->and($rules['status'])->toContain('boolean')
        ->and($rules['auto_apply'])->toContain('boolean')
        ->and($rules['locations.*'])->toContain('integer')
        ->and($rules['apply_coupon_on'])->toContain('nullable', 'in:whole_cart,menu_items,delivery_fee')
        ->and($rules['categories'])->toContain('nullable', 'array')
        ->and($rules['menus'])->toContain('nullable', 'array');
});
