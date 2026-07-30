<?php

declare(strict_types=1);

namespace Igniter\Cart\Tests\Classes;

use Igniter\Cart\Cart;
use Igniter\Cart\CartItem;
use Igniter\Cart\CartItemOption;
use Igniter\Cart\CartItemOptions;
use Igniter\Cart\CartItemOptionValue;
use Igniter\Cart\CartItemOptionValues;
use Igniter\Cart\Classes\CartConditionManager;
use Igniter\Cart\Classes\CartManager;
use Igniter\Cart\Exceptions\InvalidRowIDException;
use Igniter\Cart\Models\Mealtime;
use Igniter\Cart\Models\Menu;
use Igniter\Cart\Models\MenuItemOption;
use Igniter\Cart\Models\MenuItemOptionValue;
use Igniter\Cart\Models\MenuOption;
use Igniter\Cart\Models\MenuOptionValue;
use Igniter\Cart\Models\Order;
use Igniter\Coupons\CartConditions\Coupon;
use Igniter\Coupons\Models\Coupon as CouponModel;
use Igniter\Flame\Exception\ApplicationException;
use Igniter\Flame\Geolite\Model\Location as UserPosition;
use Igniter\Local\Classes\Location;
use Igniter\Local\Models\Location as LocationModel;
use Illuminate\Support\Facades\Event;
use Mockery;

beforeEach(function(): void {
    $this->location = LocationModel::factory()->create();
    resolve('location')->setModel($this->location);
    $conditionManager = Mockery::mock(CartConditionManager::class);
    $conditionManager->shouldReceive('listRegisteredConditions')->andReturn([
        [
            'name' => 'coupon',
            'label' => 'Coupon',
        ],
        [
            'name' => 'disabled-condition',
            'label' => 'Disabled condition',
            'status' => false,
        ],
    ]);
    $conditionManager->shouldReceive('makeCondition')->andReturn(new Coupon(['label' => 'Coupon', 'name' => 'coupon']));
    app()->instance(CartConditionManager::class, $conditionManager);

    $this->manager = new CartManager;
});

it('gets cart', function(): void {
    expect($this->manager->getCart()->currentInstance())
        ->toBe(resolve('cart')->currentInstance());
});

it('returns cart instance with location id', function(): void {
    $result = $this->manager->cartInstance(1);

    expect($result->currentInstance())->toBe('location-1');
});

it('returns cart item when row id is valid', function(): void {
    $cart = Mockery::mock(Cart::class);
    $cartItem = Mockery::mock(CartItem::class);
    $cart->shouldReceive('get')->with('validRowId')->andReturn($cartItem);
    $this->manager->setCart($cart);

    $result = $this->manager->getCartItem('validRowId');

    expect($result)->toBe($cartItem);
});

it('get cart item throws application exception when row id is invalid', function(): void {
    $cart = Mockery::mock(Cart::class);
    $cart->shouldReceive('get')->with('invalidRowId')->andThrow(InvalidRowIDException::class);
    $this->manager->setCart($cart);

    expect(fn() => $this->manager->getCartItem('invalidRowId'))
        ->toThrow(ApplicationException::class, lang('igniter.cart::default.alert_no_menu_item_found'));
});

it('finds menu item', function(): void {
    $menu = Menu::factory()->create();

    expect($this->manager->findMenuItem($menu->getKey())?->getKey())
        ->toBe($menu->getKey());

    // Find menu item again to test cache
    $this->manager->findMenuItem($menu->getKey());
});

it('finds menu item throws exception for invalid menu id', function(): void {
    expect(fn() => $this->manager->findMenuItem('invalid'))->toThrow(ApplicationException::class);
});

it('adds cart item', function(): void {
    $menu = Menu::factory()->create();

    $item = $this->manager->addCartItem($menu->getKey(), ['quantity' => 1]);

    expect($item)->toBeInstanceOf(CartItem::class)
        ->and($item->id)->toBe($menu->getKey())
        ->and($item->qty)->toBe(1);
});

it('adds cart item when menu option display type is select', function(): void {
    $menu = Menu::factory()->create();
    $option = MenuOption::factory()->create(['display_type' => 'select']);
    $menuOption = $menu->menu_options()->create(['option_id' => $option->getKey()]);
    $menuOptionValue = $menuOption->menu_option_values()->create(['option_value_id' => 1, 'price' => 10]);
    $item = $this->manager->addCartItem($menu->getKey(), [
        'quantity' => 1,
        'menu_options' => [
            $menuOption->getKey() => ['option_values' => [$menuOptionValue->getKey()]],
        ],
    ]);

    // Test cart contents validation
    $this->manager->validateContents();

    expect($item)->toBeInstanceOf(CartItem::class)
        ->and($item->options->first())->name->toBe($option->option_name)
        ->and($item->options->first()->values->first())->name->toBe($menuOptionValue->name);
});

it('allocates free quantity to checkbox option values honoring group cap and selection order', function(): void {
    $menu = Menu::factory()->create();
    $option = MenuOption::factory()->create(['display_type' => 'checkbox']);
    $menuOption = $menu->menu_options()->create(['option_id' => $option->getKey(), 'free_quantity' => 1]);

    $exemptValue = MenuOptionValue::factory()->create(['price' => 5]);
    $valueA = MenuOptionValue::factory()->create(['price' => 8]);
    $valueB = MenuOptionValue::factory()->create(['price' => 12]);

    $exemptOption = $menuOption->menu_option_values()->create(['option_value_id' => $exemptValue->getKey()]);
    $optionA = $menuOption->menu_option_values()->create(['option_value_id' => $valueA->getKey(), 'free_quantity' => 1]);
    $optionB = $menuOption->menu_option_values()->create(['option_value_id' => $valueB->getKey(), 'free_quantity' => 1]);

    $item = $this->manager->addCartItem($menu->getKey(), [
        'quantity' => 1,
        'menu_options' => [
            $menuOption->getKey() => [
                'option_values' => [$exemptOption->getKey(), $optionA->getKey(), $optionB->getKey()],
            ],
        ],
    ]);

    $values = $item->options->first()->values->keyBy('id');

    expect($values->get($exemptOption->getKey())->free_qty)->toBe(0)
        ->and($values->get($optionA->getKey())->free_qty)->toBe(1)
        ->and($values->get($optionB->getKey())->free_qty)->toBe(0)
        ->and($values->get($optionA->getKey())->price)->toBe(0.0)
        ->and($values->get($optionB->getKey())->price)->toBe(12.0);
});

it('never grants free units to an option value with a zero free_quantity budget', function(): void {
    $menu = Menu::factory()->create();
    $option = MenuOption::factory()->create(['display_type' => 'checkbox']);
    $menuOption = $menu->menu_options()->create(['option_id' => $option->getKey()]);
    $optionValue = MenuOptionValue::factory()->create(['price' => 5]);
    $menuOptionValue = $menuOption->menu_option_values()->create(['option_value_id' => $optionValue->getKey()]);

    $item = $this->manager->addCartItem($menu->getKey(), [
        'quantity' => 1,
        'menu_options' => [
            $menuOption->getKey() => ['option_values' => [$menuOptionValue->getKey()]],
        ],
    ]);

    $cartOptionValue = $item->options->first()->values->first();

    expect($cartOptionValue->free_qty)->toBe(0)
        ->and($cartOptionValue->subtotal())->toBe(5.0);
});

it('splits a quantity-type value between free and paid units when qty exceeds its free_quantity budget', function(): void {
    $menu = Menu::factory()->create();
    $option = MenuOption::factory()->create(['display_type' => 'quantity']);
    $menuOption = $menu->menu_options()->create(['option_id' => $option->getKey()]);
    $optionValue = MenuOptionValue::factory()->create(['price' => 10]);
    $menuOptionValue = $menuOption->menu_option_values()->create([
        'option_value_id' => $optionValue->getKey(),
        'free_quantity' => 1,
    ]);

    $item = $this->manager->addCartItem($menu->getKey(), [
        'quantity' => 1,
        'menu_options' => [
            $menuOption->getKey() => [
                'option_values' => [
                    $menuOptionValue->getKey() => ['qty' => 2],
                ],
            ],
        ],
    ]);

    $cartOptionValue = $item->options->first()->values->first();

    expect($cartOptionValue->qty)->toBe(2)
        ->and($cartOptionValue->free_qty)->toBe(1)
        ->and($cartOptionValue->price)->toBe(10.0)
        ->and($cartOptionValue->subtotal())->toBe(10.0);
});

it('does not add menu item option with zero quantity', function(): void {
    $menu = Menu::factory()->create();
    $option = MenuOption::firstWhere('display_type', 'checkbox');
    $menuOption = $menu->menu_options()->create(['option_id' => $option->getKey()]);
    $menuOptionValue = $menuOption->menu_option_values()->create(['option_value_id' => 1, 'price' => 10]);
    $item = $this->manager->addCartItem($menu->getKey(), [
        'quantity' => 1,
        'menu_options' => [
            $menuOption->getKey() => [
                'option_values' => [
                    $menuOptionValue->getKey() => ['id' => $menuOptionValue->getKey(), 'qty' => 0],
                ],
            ],
        ],
    ]);

    expect($item)->toBeInstanceOf(CartItem::class)
        ->and($item->options->first())->toBeNull();
});

it('does not add menu item option with invalid id', function(): void {
    $menu = Menu::factory()->create();
    $option = MenuOption::firstWhere('display_type', 'checkbox');
    $menuOption = $menu->menu_options()->create(['option_id' => $option->getKey()]);
    $menuOption->menu_option_values()->create(['option_value_id' => 1, 'price' => 10]);

    $item = $this->manager->addCartItem($menu->getKey(), [
        'quantity' => 1,
        'menu_options' => [
            $menuOption->getKey() => [
                'option_values' => [
                    ['id' => [123 => []]],
                ],
            ],
        ],
    ]);

    expect($item)->toBeInstanceOf(CartItem::class)
        ->and($item->options->first())->toBeNull();
});

it('throws exception when adding menu item quantity lower that minimum quantity', function(): void {
    $menu = Menu::factory()->create(['minimum_qty' => 2]);

    expect(fn() => $this->manager->addCartItem($menu->getKey(), ['quantity' => 1]))->toThrow(ApplicationException::class);
});

it('throws exception when adding out of stock menu item', function(): void {
    $menu = Menu::factory()->create();
    $menu->locations()->attach($this->location);
    $menu->stocks()->create([
        'is_tracked' => 1,
        'location_id' => $this->location->getKey(),
    ]);

    expect(fn() => $this->manager->addCartItem($menu->getKey(), ['quantity' => 1]))->toThrow(ApplicationException::class);
});

it('throws exception when adding menu option not between the min and max selected', function(): void {
    $menu = Menu::factory()->create();
    $option = $menu->menu_options()->create([
        'option_id' => 1,
        'min_selected' => 3,
        'max_selected' => 5,
    ]);

    expect(fn() => $this->manager->addCartItem($menu->getKey(), [
        'quantity' => 1,
        'menu_options' => [
            $option->getKey() => ['option_values' => [1, 2]],
        ],
    ]))->toThrow(ApplicationException::class);
});

it('throws exception when required menu item option is not selected', function(): void {
    $menu = Menu::factory()->create();

    $option = $menu->menu_options()->create([
        'option_id' => 1,
        'is_required' => 1,
    ]);

    expect(fn() => $this->manager->addCartItem($menu->getKey(), [
        'quantity' => 1,
        'menu_options' => [
            $option->getKey() => ['option_values' => []],
        ],
    ]))->toThrow(ApplicationException::class);
});

it('throws exception when adding menu item that does not belong to current location', function(): void {
    $menu = Menu::factory()->create();
    $menu->locations()->attach(LocationModel::factory()->create());

    expect(fn() => $this->manager->addCartItem($menu->getKey(), [
        'quantity' => 1,
    ]))->toThrow(ApplicationException::class);
});

it('updates cart item', function(): void {
    $menu = Menu::factory()->create();

    $item = $this->manager->addCartItem($menu->getKey(), ['quantity' => 1]);

    $updatedItem = $this->manager->updateCartItem($item->rowId, ['quantity' => 2]);

    expect($updatedItem->id)->toBe($menu->getKey())
        ->and($updatedItem->qty)->toBe(2);
});

it('updates cart item removes cart item when quantity is less than 1', function(): void {
    $menu = Menu::factory()->create();

    $item = $this->manager->addCartItem($menu->getKey(), ['quantity' => 1]);

    $this->manager->updateCartItem($item->rowId, ['quantity' => 0]);

    expect($this->manager->getCart()->content())->not->toHaveKey($item->rowId);
});

it('removes cart item', function(): void {
    $menu = Menu::factory()->create();

    $item = $this->manager->addCartItem($menu->getKey(), ['quantity' => 1]);

    $this->manager->removeCartItem($item->rowId);

    expect($this->manager->getCart()->content())->not->toHaveKey($item->rowId);
});

it('updates cart item quantity', function(): void {
    $menu = Menu::factory()->create();

    $item = $this->manager->addCartItem($menu->getKey(), ['quantity' => 1]);

    $updatedItem = $this->manager->updateCartItemQty($item->rowId, 2);

    expect($updatedItem->qty)->toBe(2);
});

it('increases cart item quantity', function(): void {
    $menu = Menu::factory()->create();

    $item = $this->manager->addCartItem($menu->getKey(), ['quantity' => 1]);

    $updatedItem = $this->manager->updateCartItemQty($item->rowId, 'plus');

    expect($updatedItem->qty)->toBe(2);
});

it('decreases cart item quantity', function(): void {
    $menu = Menu::factory()->create();

    $item = $this->manager->addCartItem($menu->getKey(), ['quantity' => 2]);

    $updatedItem = $this->manager->updateCartItemQty($item->rowId, 'minus');

    expect($updatedItem->qty)->toBe(1);
});

it('applies condition', function(): void {
    CouponModel::factory()->create(['code' => 'TEST']);

    $this->manager->getCart()->loadCondition(
        new Coupon(['label' => 'Coupon', 'name' => 'coupon']),
    );

    $condition = $this->manager->applyCondition('coupon', ['code' => 'TEST']);

    expect($condition->getMetaData())->toBe(['code' => 'TEST']);
});

it('applies condition returns false when condition does not exists', function(): void {
    expect($this->manager->applyCondition('no-coupon', ['code' => 'TEST']))->toBeFalse();
});

it('removes condition', function(): void {
    CouponModel::factory()->create(['code' => 'TEST']);

    $this->manager->getCart()->loadCondition(
        new Coupon(['label' => 'Coupon', 'name' => 'coupon']),
    );

    $this->manager->applyCondition('coupon', ['code' => 'TEST']);

    $this->manager->removeCondition('coupon');

    expect($this->manager->getCart()->conditions())->not->toHaveKey('coupon');
});

it('applies coupon condition when event returns CartCondition', function(): void {
    CouponModel::factory()->create(['code' => 'validCode', 'status' => 1]);
    $coupon = new Coupon(['label' => 'Coupon', 'name' => 'coupon']);
    Event::listen('igniter.cart.beforeApplyCoupon', fn($code): Coupon => $coupon);

    $result = $this->manager->applyCouponCondition('validCode');

    expect($result)->toBe($coupon);
});

it('throws exception when coupon code is invalid', function(): void {
    expect(fn() => $this->manager->applyCouponCondition('invalidCode'))
        ->toThrow(ApplicationException::class, lang('igniter.cart::default.alert_coupon_invalid'));
});

it('applies coupon condition when code is valid', function(): void {
    CouponModel::factory()->create(['code' => 'validCode', 'status' => 1]);
    $this->manager->getCart()->loadCondition(
        new Coupon(['label' => 'Coupon', 'name' => 'coupon']),
    );

    $condition = $this->manager->applyCouponCondition('validCode');

    expect($condition->getMetaData())->toBe(['code' => 'validCode']);
});

it('validateContents throws exception when cart is empty', function(): void {
    expect(fn() => $this->manager->validateContents())
        ->toThrow(ApplicationException::class, lang('igniter.cart::default.checkout.alert_no_menu_to_order'));
});

it('validateLocation throws exception when location is not set', function(): void {
    $location = Mockery::mock(Location::class);
    $location->shouldReceive('current')->andReturn(null);
    app()->instance('location', $location);

    expect(fn() => (new CartManager)->validateLocation())
        ->toThrow(ApplicationException::class, lang('igniter.local::default.alert_location_required'));
});

it('validateLocation throws exception when location delivery coverage fails', function(): void {
    $location = Mockery::mock(Location::class);
    $location->shouldReceive('current')->andReturn(Mockery::mock(LocationModel::class));
    $location->shouldReceive('orderTypeIsDelivery')->andReturnTrue();
    $location->shouldReceive('requiresUserPosition')->andReturnTrue();
    $userPosition = Mockery::mock(UserPosition::class);
    $userPosition->shouldReceive('isValid')->andReturnTrue();
    $location->shouldReceive('userPosition')->andReturn($userPosition);
    $location->shouldReceive('checkDeliveryCoverage')->andReturnFalse();
    app()->instance('location', $location);

    expect(fn() => (new CartManager)->validateLocation())
        ->toThrow(ApplicationException::class, lang('igniter.local::default.alert_no_search_query'));
});

it('validateOrderTime throws exception when location is not set', function(): void {
    $location = Mockery::mock(Location::class);
    $location->shouldReceive('current')->andReturn(null);
    app()->instance('location', $location);

    expect(fn() => (new CartManager)->validateOrderTime())
        ->toThrow(ApplicationException::class, lang('igniter.local::default.alert_location_required'));
});

it('validateOrderTime throws exception when order type is unavailable', function(): void {
    $location = Mockery::mock(Location::class);
    $location->shouldReceive('current')->andReturn(Mockery::mock(LocationModel::class));
    $location->shouldReceive('checkNoOrderTypeAvailable')->andReturn(true);
    app()->instance('location', $location);

    expect(fn() => (new CartManager)->validateOrderTime())
        ->toThrow(ApplicationException::class, lang('igniter.local::default.alert_order_type_required'));
});

it('validateOrderTime throws exception when order type is disabled', function(): void {
    $location = Mockery::mock(Location::class);
    $location->shouldReceive('current')->andReturn(Mockery::mock(LocationModel::class));
    $location->shouldReceive('checkNoOrderTypeAvailable')->andReturnFalse();
    $location->shouldReceive('getOrderType')->andReturnSelf();
    $location->shouldReceive('isDisabled')->andReturnTrue();
    $location->shouldReceive('getLabel')->andReturn('delivery');
    app()->instance('location', $location);

    expect(fn() => (new CartManager)->validateOrderTime())
        ->toThrow(ApplicationException::class, sprintf(lang('igniter.local::default.alert_order_is_unavailable'), 'delivery'));
});

it('validateOrderTime throws exception when check order time fails', function(): void {
    $location = Mockery::mock(Location::class);
    $location->shouldReceive('current')->andReturn(Mockery::mock(LocationModel::class));
    $location->shouldReceive('checkNoOrderTypeAvailable')->andReturnFalse();
    $location->shouldReceive('getOrderType')->andReturnSelf();
    $location->shouldReceive('isDisabled')->andReturnFalse();
    $location->shouldReceive('getLabel')->andReturn('delivery');
    $location->shouldReceive('checkOrderTime')->andReturnFalse();
    app()->instance('location', $location);

    expect(fn() => (new CartManager)->validateOrderTime())
        ->toThrow(ApplicationException::class, sprintf(lang('igniter.cart::default.checkout.alert_outside_hours'), 'delivery'));
});

it('validateMenuItem throws exception when menu item is not within mealtimes', function(): void {
    $location = Mockery::mock(Location::class);
    $location->shouldReceive('orderDateTime')->andReturn(now());
    app()->instance('location', $location);
    $menuItem = Mockery::mock(Menu::class)->makePartial();
    $menuItem->shouldReceive('isAvailable')->andReturnFalse();
    $menuItem->shouldReceive('extendableGet')->with('menu_name')->andReturn('Test Menu');
    $menuItem->shouldReceive('extendableGet')->with('mealtimes')->andReturn(collect([
        new Mealtime([
            'mealtime_name' => 'Lunch',
            'start_time' => '12:00',
            'end_time' => '14:00',
            'validity' => 'daily',
            'mealtime_status' => true,
        ]),
    ]));

    expect(fn() => (new CartManager)->validateMenuItem($menuItem))
        ->toThrow(ApplicationException::class, sprintf(
            lang('igniter.cart::default.alert_menu_not_within_mealtimes'), 'Test Menu', 'daily 12:00 pm - 02:00 pm',
        ));
});

it('validateMenuItem throws exception when menu item has order type restrictions', function(): void {
    $location = Mockery::mock(Location::class);
    $location->shouldReceive('orderDateTime')->andReturn(now());
    $location->shouldReceive('getOrderType')->andReturnSelf();
    $location->shouldReceive('getCode')->andReturn('delivery');
    $location->shouldReceive('getLabel')->andReturn('delivery');
    app()->instance('location', $location);
    $menuItem = Mockery::mock(Menu::class)->makePartial();
    $menuItem->shouldReceive('isAvailable')->andReturnTrue();
    $menuItem->shouldReceive('hasOrderTypeRestriction')->andReturnTrue();

    expect(fn() => (new CartManager)->validateMenuItem($menuItem))
        ->toThrow(ApplicationException::class, sprintf(
            lang('igniter.cart::default.alert_menu_order_type_restriction'), $menuItem->getBuyableName(), 'delivery',
        ));
});

it('validateMenuItemMinQty returns null when quantity or minimum quantity is zero', function(): void {
    $menuItem = Mockery::mock(Menu::class)->makePartial();
    $menuItem->shouldReceive('extendableGet')->with('minimum_qty')->andReturn(0);

    expect($this->manager->validateMenuItemMinQty($menuItem, 0))->toBeNull();
});

it('validateMenuItemMinQty throws exception when quantity is not divisible by minimum quantity', function(): void {
    $menuItem = Mockery::mock(Menu::class)->makePartial();
    $menuItem->shouldReceive('extendableGet')->with('minimum_qty')->andReturn(3);

    expect(fn() => $this->manager->validateMenuItemMinQty($menuItem, 5))
        ->toThrow(ApplicationException::class, sprintf(lang('igniter.cart::default.alert_qty_is_invalid'), 3));
});

it('validateMenuItemMinQty throws exception when quantity is below minimum quantity', function(): void {
    $menuItem = Mockery::mock(Menu::class)->makePartial();
    $menuItem->shouldReceive('extendableGet')->with('minimum_qty')->andReturn(6);
    $menuItem->shouldReceive('checkMinQuantity')->with(3)->andReturn(false);

    expect(fn() => $this->manager->validateMenuItemMinQty($menuItem, 3))
        ->toThrow(ApplicationException::class, sprintf(lang('igniter.cart::default.alert_qty_is_below_min_qty'), 6));
});

it('validateMenuItemStockQty throws exception when menu item is out of stock', function(): void {
    $locationId = $this->location->getKey();
    $menuItem = Mockery::mock(Menu::class)->makePartial();
    $menuItem->shouldReceive('outOfStock')->with($locationId)->andReturn(true);
    $menuItem->shouldReceive('extendableGet')->with('menu_name')->andReturn('Test Menu');

    expect(fn() => $this->manager->validateMenuItemStockQty($menuItem, $locationId))
        ->toThrow(ApplicationException::class, sprintf(lang('igniter.cart::default.alert_out_of_stock'), 'Test Menu'));
});

it('validateMenuItemStockQty throws exception when stock level is insufficient', function(): void {
    $locationId = $this->location->getKey();
    $menuItem = Mockery::mock(Menu::class)->makePartial();
    $menuItem->shouldReceive('outOfStock')->with($locationId)->andReturn(false);
    $menuItem->shouldReceive('checkStockLevel')->with(10, $locationId)->andReturn(false);
    $menuItem->shouldReceive('extendableGet')->with('menu_name')->andReturn('Test Menu');
    $menuItem->shouldReceive('extendableGet')->with('stocks')->andReturn(collect([
        (object)['location_id' => $locationId, 'quantity' => 5],
    ]));

    expect(fn() => $this->manager->validateMenuItemStockQty($menuItem, 10))
        ->toThrow(ApplicationException::class, sprintf(lang('igniter.cart::default.alert_low_on_stock'), 'Test Menu', 5));
});

it('validateMenuItemOption throws exception when required option is not selected', function(): void {
    $menuOption = Mockery::mock(MenuItemOption::class)->makePartial();
    $menuOption->shouldReceive('isRequired')->andReturn(true);
    $menuOption->shouldReceive('extendableGet')->with('option_name')->andReturn('Option 1');

    expect(fn() => $this->manager->validateMenuItemOption($menuOption, []))
        ->toThrow(ApplicationException::class, sprintf(lang('igniter.cart::default.alert_option_required'), 'Option 1'));
});

it('validateMenuItemOption throws exception when selected quantity is below minimum', function(): void {
    $menuOption = Mockery::mock(MenuItemOption::class)->makePartial();
    $menuOption->shouldReceive('extendableGet')->with('display_type')->andReturn('quantity');
    $menuOption->shouldReceive('extendableGet')->with('min_selected')->andReturn(2);
    $menuOption->shouldReceive('extendableGet')->with('max_selected')->andReturn(3);
    $menuOption->shouldReceive('extendableGet')->with('option_name')->andReturn('Option 1');

    $selectedValues = [
        ['qty' => 1],
    ];

    expect(fn() => $this->manager->validateMenuItemOption($menuOption, $selectedValues))
        ->toThrow(ApplicationException::class, sprintf(lang('igniter.cart::default.alert_option_selected'), 'Option 1', 2, 3));
});

it('validateMenuItemOption throws exception when selected quantity exceeds maximum', function(): void {
    $menuOption = Mockery::mock(MenuItemOption::class)->makePartial();
    $menuOption->shouldReceive('extendableGet')->with('display_type')->andReturn('quantity');
    $menuOption->shouldReceive('extendableGet')->with('min_selected')->andReturn(1);
    $menuOption->shouldReceive('extendableGet')->with('max_selected')->andReturn(2);
    $menuOption->shouldReceive('extendableGet')->with('option_name')->andReturn('Option 1');

    $selectedValues = [
        ['qty' => 1],
        ['qty' => 2],
        ['qty' => 1],
    ];

    expect(fn() => $this->manager->validateMenuItemOption($menuOption, $selectedValues))
        ->toThrow(ApplicationException::class, sprintf(lang('igniter.cart::default.alert_option_selected'), 'Option 1', 1, 2));
});

it('validateMenuItemOption throws exception when selected option is not available', function(): void {
    $menuOption = Mockery::mock(MenuItemOption::class)->makePartial();
    $menuOption->shouldReceive('extendableGet')->with('display_type')->andReturn('checkbox');
    $menuOption->shouldReceive('extendableGet')->with('option_name')->andReturn('Option 1');
    $menuOption->shouldReceive('extendableGet')->with('menu_option_values')->andReturn(collect());

    $selectedValues = [
        ['id' => 999, 'name' => 'Non-existing option'],
    ];

    expect(fn() => $this->manager->validateMenuItemOption($menuOption, $selectedValues))
        ->toThrow(ApplicationException::class, sprintf(lang('igniter.cart::default.alert_option_value_not_found'), 'Non-existing option'));
});

it('validateMenuItemOption throws exception when selected option is out of stock', function(): void {
    $menuOptionValue = Mockery::mock(MenuItemOptionValue::class)->makePartial();
    $menuOptionValue->setAttribute('menu_option_value_id', 1);
    $menuOptionValue->shouldReceive('extendableGet')->with('name')->andReturn('Option Value 1');
    $menuOptionValue->shouldReceive('extendableGet')->with('option_value')->andReturn(
        Mockery::mock(MenuOptionValue::class, function($mock): void {
            $mock->shouldReceive('outOfStock')->andReturn(true);
        })->makePartial()
    );

    $menuOption = Mockery::mock(MenuItemOption::class)->makePartial();
    $menuOption->shouldReceive('extendableGet')->with('display_type')->andReturn('checkbox');
    $menuOption->shouldReceive('extendableGet')->with('option_name')->andReturn('Option 1');
    $menuOption->shouldReceive('extendableGet')->with('menu_option_values')->andReturn(collect([
        $menuOptionValue,
    ]));

    $selectedValues = [
        ['id' => 1, 'name' => 'Option Value 1'],
    ];

    expect(fn() => $this->manager->validateMenuItemOption($menuOption, $selectedValues))
        ->toThrow(ApplicationException::class, sprintf(lang('igniter.cart::default.alert_out_of_stock'), 'Option Value 1'));
});

it('checks cart total is below minimum order total', function(): void {
    $menu = Menu::factory()->create([
        'menu_price' => 10,
    ]);

    $this->location->settings()->create([
        'item' => 'delivery',
        'data' => ['min_order_amount' => 20],
    ]);

    $this->manager->addCartItem($menu->getKey(), ['quantity' => 1]);

    expect($this->manager->cartTotalIsBelowMinimumOrder())->toBeTrue();
});

it('checks cart total is above minimum order total', function(): void {
    $menu = Menu::factory()->create([
        'menu_price' => 30,
    ]);

    $this->location->settings()->create([
        'item' => 'delivery',
        'data' => ['min_order_amount' => 20],
    ]);

    $this->manager->addCartItem($menu->getKey(), ['quantity' => 1]);

    expect($this->manager->cartTotalIsBelowMinimumOrder())->toBeFalse();
});

it('checks delivery charge is unavailable', function(): void {
    $menu = Menu::factory()->create([
        'menu_price' => 30,
    ]);

    $this->manager->addCartItem($menu->getKey(), ['quantity' => 1]);

    expect($this->manager->deliveryChargeIsUnavailable())->toBeFalse();
});

it('restores cart with order menu items', function(): void {
    $menu1 = Menu::factory()->create();
    $menu2 = Menu::factory()->create(['minimum_qty' => 2]);
    $order = Order::factory()->create();
    $option = MenuOption::firstWhere('display_type', 'checkbox');
    $menuOption1 = $menu1->menu_options()->create(['option_id' => $option->getKey()]);
    $menuOption2 = $menu1->menu_options()->create(['option_id' => $option->getKey(), 'min_selected' => 2, 'max_selected' => 3]);
    $menuOptionValue = $menuOption1->menu_option_values()->create(['option_value_id' => 1, 'price' => 10]);

    $order->addOrderMenus([
        (object)[
            'id' => $menu2->getKey(),
            'name' => $menu2->menu_name,
            'qty' => 1,
            'price' => $menu2->menu_price,
            'subtotal' => $menu2->menu_price,
            'comment' => '',
            'options' => [],
        ],
        (object)[
            'id' => $menu1->getKey(),
            'name' => $menu1->menu_name,
            'qty' => $menu1->minimum_qty,
            'price' => $menu1->menu_price,
            'subtotal' => $menu1->menu_price,
            'comment' => 'Special instructions',
            'options' => CartItemOptions::make([
                CartItemOption::fromArray([
                    'id' => 1,
                    'name' => 'Option 1',
                    'values' => CartItemOptionValues::make(),
                ]),
                CartItemOption::fromArray([
                    'id' => $menuOption2->getKey(),
                    'name' => 'Option 1',
                    'values' => CartItemOptionValues::make(),
                ]),
                CartItemOption::fromArray([
                    'id' => $menuOption1->getKey(),
                    'name' => 'Option 2',
                    'values' => CartItemOptionValues::make([
                        CartItemOptionValue::fromArray([
                            'id' => $menuOptionValue->getKey(),
                            'name' => 'Option 1',
                            'price' => 10,
                            'qty' => 1,
                        ]),
                    ]),
                ]),
            ]),
        ],
    ]);

    $notes = $this->manager->restoreWithOrderMenus($order->getOrderMenus());

    expect($this->manager->getCart()->content())->toHaveCount(1)
        ->and($notes)->toContain(sprintf(
            lang('igniter.cart::default.alert_qty_is_below_min_qty'), $menu2->minimum_qty,
        ))
        ->and($notes)->toContain(sprintf(
            lang('igniter.cart::default.alert_option_selected'),
            $menuOption2->option_name,
            $menuOption2->min_selected,
            $menuOption2->max_selected,
        ));
});
