<?php

declare(strict_types=1);

namespace Igniter\Cart\Tests\Models;

use Igniter\Cart\Models\MenuItemOption;
use Igniter\Cart\Models\OrderMenuOptionValue;

it('returns order option category attribute', function(): void {
    $orderMenuOptionValue = new OrderMenuOptionValue;
    $menuItemOption = MenuItemOption::factory()->create();
    $orderMenuOptionValue->menu_option = $menuItemOption;

    expect($orderMenuOptionValue->order_option_category)->toBe($menuItemOption->option->option_name);
});

it('configures order menu option value model correctly', function(): void {
    $orderMenuOptionValue = new OrderMenuOptionValue;
    expect($orderMenuOptionValue->getTable())->toBe('order_menu_options')
        ->and($orderMenuOptionValue->getKeyName())->toBe('order_option_id')
        ->and($orderMenuOptionValue->getGuarded())->toBe([])
        ->and($orderMenuOptionValue->getAppends())->toBe(['order_option_category']);
});
