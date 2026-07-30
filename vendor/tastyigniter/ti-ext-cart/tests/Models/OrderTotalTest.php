<?php

declare(strict_types=1);

namespace Igniter\Cart\Tests\Models;

use Igniter\Cart\Models\OrderTotal;

it('configures order total model correctly', function(): void {
    $orderTotal = new OrderTotal;
    expect($orderTotal->getTable())->toBe('order_totals')
        ->and($orderTotal->getKeyName())->toBe('order_total_id')
        ->and($orderTotal->getGuarded())->toBe([]);
});
