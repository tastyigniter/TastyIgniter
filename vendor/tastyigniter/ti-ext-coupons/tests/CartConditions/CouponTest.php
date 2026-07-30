<?php

declare(strict_types=1);

namespace Igniter\Cart\Tests\CartConditions;

use Igniter\Cart\CartContent;
use Igniter\Cart\CartItem;
use Igniter\Cart\Facades\Cart;
use Igniter\Cart\Models\Category;
use Igniter\Cart\Models\Menu;
use Igniter\Coupons\CartConditions\Coupon;
use Igniter\Coupons\Models\Coupon as CouponModel;
use Igniter\Local\Facades\Location;
use Igniter\Local\Models\Location as LocationModel;
use Igniter\User\Facades\Auth;
use Igniter\User\Models\Customer;
use Igniter\User\Models\CustomerGroup;

beforeEach(function(): void {
    $this->coupon = CouponModel::factory()->create([
        'code' => 'test-coupon',
        'name' => 'Test Coupon',
        'type' => 'F',
        'discount' => 10,
    ]);
    $this->couponCondition = new Coupon([
        'name' => 'Coupon',
        'label' => 'Coupon: %s',
        'metaData' => ['code' => $this->coupon->code],
    ]);
});

afterEach(function(): void {
    Coupon::clearInternalCache();
});

it('gets label correctly', function(): void {
    expect($this->couponCondition->getLabel())->toBe('Coupon: test-coupon');
});

it('gets value correctly', function(): void {
    $this->couponCondition->calculate(20);

    expect($this->couponCondition->getValue())->toBe(-10.0);
});

it('gets model correctly', function(): void {
    expect($this->couponCondition->getModel()->getKey())->toBe($this->coupon->getKey());
});

it('gets model returns null when code is missing in metadata', function(): void {
    $this->couponCondition->clearMetaData();

    expect($this->couponCondition->getModel())->toBeNull();
});

it('gets applicable items correctly', function(): void {
    $category = Category::factory()->create();
    $category->menus()->save($categoryMenu = Menu::factory()->create());
    $this->coupon->menus()->save($menu = Menu::factory()->create());
    $this->coupon->categories()->save($category);

    expect($this->couponCondition->getApplicableItems($this->coupon))->toContain($menu->getKey(), $categoryMenu->getKey());
});

it('throws exception when invalid coupon is loaded', function(): void {
    $this->couponCondition->setMetaData(['code' => 'invalid']);

    $this->couponCondition->onLoad();

    expect($this->couponCondition->getMetaData('code'))->toBeNull();
});

it('does not apply when code is missing in metadata', function(): void {
    $this->couponCondition->clearMetaData();

    expect($this->couponCondition->onLoad())->toBeNull();
});

it('flashes error if coupon is expired', function(): void {
    $this->coupon->validity = 'period';
    $this->coupon->period_start_date = now()->subDays(2);
    $this->coupon->period_end_date = now()->subDay();
    $this->coupon->save();
    Location::shouldReceive('getId')->andReturn(1);
    Location::shouldReceive('orderType')->andReturn('delivery');
    Location::shouldReceive('orderDateTime')->andReturn(now());

    $this->couponCondition->onLoad();

    expect(flash()->messages()->first())->level->toBe('info')
        ->message->toBe(lang('igniter.cart::default.alert_coupon_expired'));
});

it('flashes error if coupon has order type restriction', function(): void {
    $this->coupon->validity = 'forever';
    $this->coupon->order_restriction = ['delivery'];
    $this->coupon->save();
    Location::shouldReceive('getId')->andReturn(1);
    Location::shouldReceive('orderType')->andReturn('collection');
    Location::shouldReceive('orderDateTime')->andReturn(now());

    $this->couponCondition->onLoad();

    expect(flash()->messages()->first())->level->toBe('info')
        ->message->toBe(sprintf(lang('igniter.cart::default.alert_coupon_order_restriction'), 'collection'));
});

it('flashes error if coupon has location restriction', function(): void {
    $this->coupon->validity = 'forever';
    $this->coupon->save();
    $location = LocationModel::factory()->create();
    $this->coupon->locations()->save($location);
    Location::shouldReceive('getId')->andReturn(1);
    Location::shouldReceive('orderType')->andReturn('collection');
    Location::shouldReceive('orderDateTime')->andReturn(now());

    $this->couponCondition->onLoad();

    expect(flash()->messages()->first())->level->toBe('info')
        ->message->toBe(lang('igniter.cart::default.alert_coupon_location_restricted'));
});

it('flashes error if cart subtotal is less than minimum order total', function(): void {
    $this->coupon->validity = 'forever';
    $this->coupon->min_total = 10;
    $this->coupon->save();
    Location::shouldReceive('getId')->andReturn(1);
    Location::shouldReceive('orderType')->andReturn('collection');
    Location::shouldReceive('orderDateTime')->andReturn(now());
    Cart::shouldReceive('content')->andReturn(mock(CartContent::class, function($mockedCartContent): void {
        $mockedCartContent->shouldReceive('subtotalWithoutConditions')->andReturn(5);
    }));

    $this->couponCondition->onLoad();

    expect(flash()->messages()->first())->level->toBe('info')
        ->message->toBe(sprintf(lang('igniter.cart::default.alert_coupon_not_applied'), currency_format(10)));
});

it('flashes error if coupon has reached max redemption', function(): void {
    $this->coupon->validity = 'forever';
    $this->coupon->redemptions = 1;
    $this->coupon->save();
    $this->coupon->history()->create(['order_id' => 1, 'status' => 1]);
    Location::shouldReceive('getId')->andReturn(1);
    Location::shouldReceive('orderType')->andReturn('collection');
    Location::shouldReceive('orderDateTime')->andReturn(now());
    Cart::shouldReceive('content')->andReturn(mock(CartContent::class, function($mockedCartContent): void {
        $mockedCartContent->shouldReceive('subtotalWithoutConditions')->andReturn(10);
    }));

    $this->couponCondition->onLoad();

    expect(flash()->messages()->first())->level->toBe('info')
        ->message->toBe(lang('igniter.cart::default.alert_coupon_maximum_reached'));
});

it('flashes error if customer is not logged in and coupon requires login', function(): void {
    $this->coupon->validity = 'forever';
    $this->coupon->save();
    $this->coupon->customers()->save(Customer::factory()->create());
    Location::shouldReceive('getId')->andReturn(1);
    Location::shouldReceive('orderType')->andReturn('collection');
    Location::shouldReceive('orderDateTime')->andReturn(now());
    Cart::shouldReceive('content')->andReturn(mock(CartContent::class, function($mockedCartContent): void {
        $mockedCartContent->shouldReceive('subtotalWithoutConditions')->andReturn(10);
    }));

    $this->couponCondition->onLoad();

    expect(flash()->messages()->first())->level->toBe('info')
        ->message->toBe(lang('igniter.coupons::default.alert_coupon_login_required'));
});

it('flashes error if customer has reached max redemption for coupon', function(): void {
    $customer = Customer::factory()->create();
    $this->coupon->validity = 'forever';
    $this->coupon->customer_redemptions = 1;
    $this->coupon->save();
    $this->coupon->history()->create(['customer_id' => $customer->getKey(), 'order_id' => 1, 'status' => 1]);
    Auth::shouldReceive('user')->andReturn($customer);
    Location::shouldReceive('getId')->andReturn(1);
    Location::shouldReceive('orderType')->andReturn('collection');
    Location::shouldReceive('orderDateTime')->andReturn(now());
    Cart::shouldReceive('content')->andReturn(mock(CartContent::class, function($mockedCartContent): void {
        $mockedCartContent->shouldReceive('subtotalWithoutConditions')->andReturn(10);
    }));

    $this->couponCondition->onLoad();

    expect(flash()->messages()->first())->level->toBe('info')
        ->message->toBe(lang('igniter.cart::default.alert_coupon_maximum_reached'));
});

it('flashes error if coupon has customer restriction', function(): void {
    $customer1 = Customer::factory()->create();
    $customer2 = Customer::factory()->create();
    $this->coupon->validity = 'forever';
    $this->coupon->save();
    $this->coupon->customers()->save($customer1);
    Auth::shouldReceive('user')->andReturn($customer2);
    Location::shouldReceive('getId')->andReturn(1);
    Location::shouldReceive('orderType')->andReturn('collection');
    Location::shouldReceive('orderDateTime')->andReturn(now());
    Cart::shouldReceive('content')->andReturn(mock(CartContent::class, function($mockedCartContent): void {
        $mockedCartContent->shouldReceive('subtotalWithoutConditions')->andReturn(10);
    }));

    $this->couponCondition->onLoad();

    expect(flash()->messages()->first())->level->toBe('info')
        ->message->toBe(lang('igniter.coupons::default.alert_customer_cannot_redeem'));
});

it('flashes error if coupon has customer group restriction', function(): void {
    $customerGroup1 = CustomerGroup::factory()->create();
    $customerGroup2 = CustomerGroup::factory()->create();
    $customer = mock(Customer::class)->makePartial();
    $customer->shouldReceive('extendableGet')->with('group')->andReturn($customerGroup2);
    $this->coupon->validity = 'forever';
    $this->coupon->save();
    $this->coupon->customer_groups()->save($customerGroup1);
    Auth::shouldReceive('user')->andReturn($customer);
    Location::shouldReceive('getId')->andReturn(1);
    Location::shouldReceive('orderType')->andReturn('collection');
    Location::shouldReceive('orderDateTime')->andReturn(now());
    Cart::shouldReceive('content')->andReturn(mock(CartContent::class, function($mockedCartContent): void {
        $mockedCartContent->shouldReceive('subtotalWithoutConditions')->andReturn(10);
    }));

    $this->couponCondition->onLoad();

    expect(flash()->messages()->first())->level->toBe('info')
        ->message->toBe(lang('igniter.coupons::default.alert_customer_group_cannot_redeem'));
});

it('loads coupon condition successfully', function(): void {
    $this->coupon->validity = 'forever';
    $this->coupon->save();
    Location::shouldReceive('getId')->andReturn(1);
    Location::shouldReceive('orderType')->andReturn('collection');
    Location::shouldReceive('orderDateTime')->andReturn(now());
    Cart::shouldReceive('content')->andReturn(mock(CartContent::class, function($mockedCartContent): void {
        $mockedCartContent->shouldReceive('subtotalWithoutConditions')->andReturn(10);
    }));

    $this->couponCondition->onLoad();

    expect(flash()->messages())->toBeEmpty();
});

it('does not apply when applies on menu items only', function(): void {
    $this->coupon->apply_coupon_on = 'menu_items';
    $this->coupon->save();

    Location::shouldReceive('orderTypeIsDelivery')->never();

    expect($this->couponCondition->beforeApply())->toBeFalse();
});

it('does not apply when applies on delivery charge only', function(): void {
    $this->coupon->apply_coupon_on = 'delivery_fee';
    $this->coupon->save();

    Location::shouldReceive('orderTypeIsDelivery')->once()->andReturn(false);

    expect($this->couponCondition->beforeApply())->toBeFalse();
});

it('gets actions with percentage fee', function(): void {
    $this->coupon->type = 'P';
    $this->coupon->save();

    expect($this->couponCondition->getActions())->toBe([['value' => '-%10']]);
});

it('gets actions with fixed fee', function(): void {
    expect($this->couponCondition->getActions())->toBe([['value' => '-10']]);
});

it('returns calculated delivery fixed discount value', function(): void {
    $this->coupon->type = 'F';
    $this->coupon->apply_coupon_on = 'delivery_fee';
    $this->coupon->save();

    Location::shouldReceive('coveredArea->deliveryAmount')->once()->andReturn(15);
    Cart::shouldReceive('subtotal')->once()->andReturn(10);

    expect($this->couponCondition->getActions())->toBe([['value' => '-10']]);
});

it('returns calculated delivery charge when fixed discount value is greater than delivery charge', function(): void {
    $this->coupon->type = 'F';
    $this->coupon->apply_coupon_on = 'delivery_fee';
    $this->coupon->save();

    Location::shouldReceive('coveredArea->deliveryAmount')->once()->andReturn(5);
    Cart::shouldReceive('subtotal')->once()->andReturn(10);

    expect($this->couponCondition->getActions())->toBe([['value' => '-5']]);
});

it('returns calculated percentage delivery discount value', function(): void {
    $this->coupon->type = 'P';
    $this->coupon->apply_coupon_on = 'delivery_fee';
    $this->coupon->save();

    Location::shouldReceive('coveredArea->deliveryAmount')->once()->andReturn(5);
    Cart::shouldReceive('subtotal')->once()->andReturn(10);

    expect($this->couponCondition->getActions())->toBe([['value' => '-0.5']]);
});

it('returns apportioned discount value for menu items', function(): void {
    $this->coupon->type = 'F';
    $this->coupon->apply_coupon_on = 'menu_items';
    $this->coupon->save();

    $menu = Menu::factory()->create(['menu_price' => 10]);
    $menu2 = Menu::factory()->create(['menu_price' => 20]);
    $menu3 = Menu::factory()->create(['menu_price' => 30]);
    $this->coupon->menus()->saveMany([$menu, $menu2]);
    $category = Category::factory()->create();
    $category->menus()->save($menu3);
    $this->coupon->categories()->save($category);

    $cartContent = new CartContent([
        $cartItem1 = mock(CartItem::class),
        $cartItem2 = mock(CartItem::class),
        $cartItem3 = mock(CartItem::class),
    ]);
    Cart::shouldReceive('content')->andReturn($cartContent);
    $cartItem1->id = 1;
    $cartItem1->qty = 1;
    $cartItem2->id = $menu->getKey();
    $cartItem2->qty = 1;
    $cartItem3->id = $menu3->getKey();
    $cartItem3->qty = 1;
    $cartItem2->shouldReceive('subtotalWithoutConditions')->andReturn(20);
    $cartItem3->shouldReceive('subtotalWithoutConditions')->andReturn(30);

    $this->couponCondition->withTarget($cartItem2);
    $this->couponCondition->getApplicableItems($this->coupon);

    expect($this->couponCondition->getActions())->toBe([['value' => -4.0]]);
});

it('displays warning and removes code when coupon is invalid and not auto applied', function(): void {
    $this->coupon->auto_apply = false;
    $this->coupon->min_total = 100;
    $this->coupon->save();

    $this->couponCondition->whenInvalid();

    expect(flash()->messages()->first())->level->toBe('warning')->message->toBe(sprintf(
        lang('igniter.cart::default.alert_coupon_not_applied'),
        currency_format(100),
    ));
});

it('is applicable to cart item', function(): void {
    $this->coupon->apply_coupon_on = 'menu_items';
    $this->coupon->save();

    $this->coupon->menus()->save($menu = Menu::factory()->create());

    $this->couponCondition->getModel();
    $this->couponCondition->getApplicableItems($this->coupon);

    expect($this->couponCondition->isApplicableTo((object)['id' => $menu->getKey(), 'qty' => 1]))->toBeTrue();
});

it('is applicable to cart item when cart item quantity is less then minimum menu quantity', function(): void {
    $this->coupon->apply_coupon_on = 'menu_items';
    $this->coupon->min_menu_quantity = 2;
    $this->coupon->save();

    $this->coupon->menus()->save($menu = Menu::factory()->create());

    $this->couponCondition->getModel();
    $this->couponCondition->getApplicableItems($this->coupon);

    expect($this->couponCondition->isApplicableTo((object)['id' => $menu->getKey(), 'qty' => 1]))->toBeFalse();
});

it('is not applicable to cart item when coupon model is null', function(): void {
    $cartItem = mock(CartItem::class);
    expect($this->couponCondition->isApplicableTo($cartItem))->toBeFalse();
});

it('is not applicable to cart item when not applicable', function(): void {
    $cartItem = mock(CartItem::class);
    $this->coupon->apply_coupon_on = 'delivery_fee';
    $this->coupon->save();
    $this->couponCondition->getModel();

    expect($this->couponCondition->isApplicableTo($cartItem))->toBeFalse();
});

it('returns false if applicable items are null', function(): void {
    $cartItem = mock(CartItem::class);
    $this->coupon->apply_coupon_on = 'menu_items';
    $this->coupon->save();
    $this->couponCondition->getModel();

    expect($this->couponCondition->isApplicableTo($cartItem))->toBeFalse();
});

it('returns false if coupon does not apply on menu items', function(): void {
    $cartItem = mock(CartItem::class);
    $this->coupon->apply_coupon_on = 'menu_items';
    $this->coupon->save();
    $this->coupon->menus()->save(Menu::factory()->create());

    $this->couponCondition->getModel();
    $this->couponCondition->getApplicableItems($this->coupon);

    expect($this->couponCondition->isApplicableTo($cartItem))->toBeFalse();
});
