<?php

declare(strict_types=1);

namespace Igniter\Cart\Tests;

use Igniter\Cart\CartItemOptionValue;

it('computes subtotal without free units', function(): void {
    $optionValue = new CartItemOptionValue(1, 'Cheese', 10);
    $optionValue->setQuantity(3);

    expect($optionValue->subtotal())->toBe(30.0);
});

it('deducts free units from subtotal', function(): void {
    $optionValue = new CartItemOptionValue(1, 'Cheese', 10);
    $optionValue->setQuantity(3);
    $optionValue->setFreeQty(2);

    expect($optionValue->subtotal())->toBe(10.0);
});

it('never goes below zero chargeable units when free_qty exceeds qty', function(): void {
    $optionValue = new CartItemOptionValue(1, 'Cheese', 10);
    $optionValue->setQuantity(1);
    $optionValue->setFreeQty(5);

    expect($optionValue->subtotal())->toBe(0.0);
});

it('includes free_qty in array and json representations', function(): void {
    $optionValue = new CartItemOptionValue(1, 'Cheese', 10);
    $optionValue->setFreeQty(1);

    expect($optionValue->toArray())->toHaveKey('free_qty', 1);
});
