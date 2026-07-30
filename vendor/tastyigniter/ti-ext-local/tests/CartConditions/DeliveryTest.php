<?php

declare(strict_types=1);

namespace Igniter\Local\Tests\CartConditions;

use Igniter\Cart\Facades\Cart;
use Igniter\Local\CartConditions\Delivery;
use Igniter\Local\Classes\CoveredArea;
use Igniter\Local\Facades\Location;
use Igniter\Local\Models\Location as LocationModel;

it('does not apply when order type is not delivery', function(): void {
    Location::shouldReceive('orderType')->once()->andReturn(LocationModel::COLLECTION);

    $delivery = new Delivery;

    expect($delivery->beforeApply())->toBeFalse();
});

it('calculates delivery charge correctly', function(): void {
    Location::shouldReceive('orderType')->once()->andReturn(LocationModel::DELIVERY);
    Cart::shouldReceive('subtotal')->once()->andReturn(100);
    $coveredArea = mock(CoveredArea::class);
    $coveredArea->shouldReceive('deliveryAmount')->once()->with(100)->andReturn(10);
    Location::shouldReceive('coveredArea')->once()->andReturn($coveredArea);

    $delivery = new Delivery;
    $delivery->beforeApply();

    expect($delivery->getRules())->toBeArray()->and($delivery->getRules())->toContain('10 >= 0')
        ->and($delivery->getActions())->toBeArray()->and($delivery->getActions())->toContain(['value' => '+10']);
});

it('returns free when calculated value is zero', function(): void {
    Location::shouldReceive('orderType')->once()->andReturn(LocationModel::DELIVERY);
    Cart::shouldReceive('subtotal')->once()->andReturn(100);
    $coveredArea = mock(CoveredArea::class);
    $coveredArea->shouldReceive('deliveryAmount')->once()->with(100)->andReturn(0);
    Location::shouldReceive('coveredArea')->once()->andReturn($coveredArea);

    $delivery = new Delivery;
    $delivery->beforeApply();
    $delivery->calculate(100);

    expect($delivery->getValue())->toBe(lang('igniter::main.text_free'));
});

it('returns calculated value when it is more than zero', function(): void {
    Location::shouldReceive('orderType')->once()->andReturn(LocationModel::DELIVERY);
    Cart::shouldReceive('subtotal')->once()->andReturn(100);
    $coveredArea = mock(CoveredArea::class);
    $coveredArea->shouldReceive('deliveryAmount')->once()->with(100)->andReturn(10);
    Location::shouldReceive('coveredArea')->once()->andReturn($coveredArea);

    $delivery = new Delivery;
    $delivery->beforeApply();
    $delivery->calculate(100);

    expect($delivery->getValue())->toBe(10.0);
});
