<?php

declare(strict_types=1);

namespace Igniter\Cart\Tests\Models;

use Igniter\Cart\Models\Cart;

it('configures cart model correctly', function(): void {
    $cart = new Cart;

    expect($cart->getTable())->toEqual('igniter_cart_cart')
        ->and($cart->getKeyName())->toEqual('identifier')
        ->and($cart->getIncrementing())->toBeFalse()
        ->and($cart->timestamps)->toBeTrue()
        ->and($cart->isUnguarded())->toBeTrue();
});
