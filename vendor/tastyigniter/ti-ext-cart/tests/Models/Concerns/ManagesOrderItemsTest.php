<?php

declare(strict_types=1);

namespace Igniter\Cart\Tests\Models\Concerns;

use Igniter\Cart\CartItemOption;
use Igniter\Cart\CartItemOptions;
use Igniter\Cart\CartItemOptionValue;
use Igniter\Cart\CartItemOptionValues;
use Igniter\Cart\Models\Menu;
use Igniter\Cart\Models\MenuItemOption;
use Igniter\Cart\Models\MenuItemOptionValue;
use Igniter\Cart\Models\MenuOptionValue;
use Igniter\Cart\Models\Order;
use Igniter\Cart\Models\OrderMenu;
use Igniter\Cart\Models\OrderMenuOptionValue;
use Igniter\Cart\Models\Stock;

it('subtracts stock correctly', function(): void {
    $order = Order::factory()->create();

    $menu = Menu::factory()
        ->hasAttached($order->location)
        ->create();

    $menuStock = Stock::factory()
        ->for($order->location)
        ->for($menu, 'stockable')
        ->create(['quantity' => 10]);

    $menuOptionValue = MenuOptionValue::factory()->create();
    $menuItemOptionValue = MenuItemOptionValue::factory()->create([
        'option_value_id' => $menuOptionValue->getKey(),
    ]);
    $menuItemOptionValue2 = MenuItemOptionValue::factory()->create([
        'option_value_id' => 123,
    ]);
    $menuOptionStock = Stock::factory()
        ->for($order->location)
        ->for($menuOptionValue, 'stockable')
        ->create(['quantity' => 10]);

    OrderMenu::create([
        'order_id' => $order->getKey(),
        'menu_id' => 123,
        'quantity' => 5,
    ]);
    $orderMenu = OrderMenu::create([
        'order_id' => $order->getKey(),
        'menu_id' => $menu->getKey(),
        'quantity' => 5,
    ]);

    $orderMenu->menu_options()->create([
        'order_id' => $order->getKey(),
        'order_menu_id' => $orderMenu->getKey(),
        'menu_option_value_id' => 123,
        'quantity' => 5,
    ]);
    $orderMenu->menu_options()->create([
        'order_id' => $order->getKey(),
        'order_menu_id' => $orderMenu->getKey(),
        'menu_option_value_id' => $menuItemOptionValue->getKey(),
        'quantity' => 5,
    ]);
    $orderMenu->menu_options()->create([
        'order_id' => $order->getKey(),
        'order_menu_id' => $orderMenu->getKey(),
        'menu_option_value_id' => $menuItemOptionValue2->getKey(),
        'quantity' => 5,
    ]);

    $order->subtractStock();

    $menuStock->refresh();
    $menuOptionStock->refresh();

    expect($menuStock->quantity)->toBe(5)
        ->and($menuOptionStock->quantity)->toBe(5);
});

it('gets order menus correctly', function(): void {
    $order = Order::factory()->create();
    $menu = Menu::factory()->create();

    $orderMenu = OrderMenu::create([
        'order_id' => $order->getKey(),
        'menu_id' => $menu->getKey(),
    ]);

    $orderMenus = $order->getOrderMenus();

    expect($orderMenus->first()->menu_id)->toBe($orderMenu->menu_id);
});

it('gets order menu options correctly', function(): void {
    $order = Order::factory()->create();
    $menu = Menu::factory()->create();
    $menuItemOption = MenuItemOption::factory()->create();
    $menuItemOptionValue = MenuItemOptionValue::factory()->create();

    $orderMenu = OrderMenu::create([
        'order_id' => $order->getKey(),
        'menu_id' => $menu->getKey(),
    ]);

    $orderMenuOptionValue = OrderMenuOptionValue::create([
        'order_id' => $order->getKey(),
        'order_menu_id' => $orderMenu->getKey(),
        'menu_option_id' => $menuItemOption->getKey(),
        'menu_option_value_id' => $menuItemOptionValue->getKey(),
    ]);

    $orderMenuOption = $order->getOrderMenuOptions()->first()->first();

    expect($orderMenuOption->order_menu_id)->toBe($orderMenuOptionValue->order_menu_id)
        ->and($order->getOrderMenusWithOptions()->toArray())->toBeArray();
});

it('gets order totals correctly', function(): void {
    $order = Order::factory()->create();

    $order->totals()->create([
        'code' => 'subtotal',
        'title' => 'Subtotal',
        'value' => 10.00,
    ]);

    $orderTotals = $order->getOrderTotals();

    expect($orderTotals->first())->code->toBe('subtotal');
});

it('adds order totals correctly', function(): void {
    $order = Order::factory()->create();
    OrderMenu::create([
        'order_id' => $order->getKey(),
        'quantity' => 5,
        'price' => 10,
        'subtotal' => 10,
    ]);

    $order->addOrderTotals([
        ['code' => 'tax', 'title' => 'Tax', 'value' => 1.00, 'is_summable' => true],
        ['code' => 'service-charge', 'title' => 'Service charge', 'value' => 21.00, 'is_summable' => false],
        ['code' => 'total', 'title' => 'Total', 'value' => 11.00],
    ]);

    $order = $order->fresh();
    expect($order->totals()->count())->toBe(3)
        ->and($order->order_total)->toBe(11.00);
});

it('stores zero price for fully free order menu options', function(): void {
    $order = Order::factory()->create();
    $menu = Menu::factory()->create();

    $order->addOrderMenus([
        (object)[
            'id' => $menu->getKey(),
            'name' => $menu->menu_name,
            'qty' => 1,
            'price' => $menu->menu_price,
            'subtotal' => $menu->menu_price,
            'comment' => '',
            'options' => CartItemOptions::make([
                CartItemOption::fromArray([
                    'id' => 1,
                    'name' => 'Toppings',
                    'values' => CartItemOptionValues::make([
                        CartItemOptionValue::fromArray([
                            'id' => 1,
                            'name' => 'Cheese',
                            'price' => 10,
                            'qty' => 1,
                            'free_qty' => 1,
                        ]),
                    ]),
                ]),
            ]),
        ],
    ]);

    $storedOption = $order->fresh()->menu_options->first();

    expect($storedOption->order_option_price)->toBe(0.0)
        ->and($storedOption->free_qty)->toBe(1);
});

it('stores unit price for partially free order menu options', function(): void {
    $order = Order::factory()->create();
    $menu = Menu::factory()->create();

    $order->addOrderMenus([
        (object)[
            'id' => $menu->getKey(),
            'name' => $menu->menu_name,
            'qty' => 1,
            'price' => $menu->menu_price,
            'subtotal' => $menu->menu_price,
            'comment' => '',
            'options' => CartItemOptions::make([
                CartItemOption::fromArray([
                    'id' => 1,
                    'name' => 'Toppings',
                    'values' => CartItemOptionValues::make([
                        CartItemOptionValue::fromArray([
                            'id' => 1,
                            'name' => 'Cheese',
                            'price' => 10,
                            'qty' => 2,
                            'free_qty' => 1,
                        ]),
                    ]),
                ]),
            ]),
        ],
    ]);

    $storedOption = $order->fresh()->menu_options->first();

    expect($storedOption->order_option_price)->toBe(10.0)
        ->and($storedOption->free_qty)->toBe(1);
});
