<?php

declare(strict_types=1);

namespace Igniter\Cart\Tests\CartConditions;

use Igniter\Cart\CartConditions\Tax;
use Igniter\Local\Facades\Location;

beforeEach(function(): void {
    $this->tax = new Tax(['label' => 'VAT: %s']);
});

it('gets label with inclusive tax', function(): void {
    setting()->set([
        'tax_mode' => 1,
        'tax_menu_price' => 0,
        'tax_percentage' => 10,
    ]);

    $this->tax->onLoad();

    expect($this->tax->getLabel())->toBe('VAT: 10% included');
});

it('gets label without inclusive tax', function(): void {
    setting()->set([
        'tax_mode' => 1,
        'tax_menu_price' => 1,
        'tax_percentage' => 10,
    ]);

    $this->tax->onLoad();

    expect($this->tax->getLabel())->toBe('VAT: 10%');
});

it('before apply with no tax mode', function(): void {
    setting()->set([
        'tax_mode' => 0,
        'tax_menu_price' => 0,
        'tax_percentage' => 10,
    ]);

    $this->tax->onLoad();

    expect($this->tax->beforeApply())->toBeFalse();
});

it('before apply with no tax rate', function(): void {
    setting()->set([
        'tax_mode' => 1,
        'tax_menu_price' => 0,
        'tax_percentage' => 0,
    ]);

    $this->tax->onLoad();

    expect($this->tax->beforeApply())->toBeFalse();
});

it('gets actions with inclusive tax', function(): void {
    setting()->set([
        'tax_mode' => 1,
        'tax_menu_price' => 0,
        'tax_percentage' => $taxRate = 10,
    ]);

    $this->tax->onLoad();

    $taxRate /= (100 + $taxRate) / 100;

    expect($this->tax->getActions())->toBe([
        ['value' => '+'.$taxRate.'%', 'inclusive' => true, 'valuePrecision' => 2],
    ]);
});

it('gets actions without inclusive tax', function(): void {
    setting()->set([
        'tax_mode' => 1,
        'tax_menu_price' => 1,
        'tax_percentage' => 10,
    ]);

    $this->tax->onLoad();

    expect($this->tax->getActions())->toBe([
        ['value' => '+10%', 'inclusive' => false, 'valuePrecision' => 2],
    ]);
});

it('calculates tax excluding delivery charge when order type is delivery and taxDelivery is false', function(): void {
    setting()->set([
        'tax_mode' => 1,
        'tax_menu_price' => 1,
        'tax_percentage' => 10,
    ]);

    Location::shouldReceive('orderTypeIsDelivery')->andReturn(true);
    Location::shouldReceive('coveredArea->deliveryAmount')->with(100.0)->andReturn(5.0);

    $this->tax->onLoad();
    $result = $this->tax->calculate(100.0);

    expect($result)->toBe(109.5);
});
