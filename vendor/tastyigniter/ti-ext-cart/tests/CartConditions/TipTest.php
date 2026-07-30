<?php

declare(strict_types=1);

namespace Igniter\Cart\Tests\CartConditions;

use Igniter\Cart\CartConditions\Tip;
use Igniter\Cart\Models\CartSettings;

beforeEach(function(): void {
    $this->tip = new Tip(['label' => 'Test Tip']);
});

it('gets label', function(): void {
    expect($this->tip->getLabel())->toBe('Test Tip');
});

it('before apply with tipping disabled', function(): void {
    CartSettings::set('enable_tipping', false);

    $this->tip->onLoad();

    expect($this->tip->beforeApply())->toBeFalse();
});

it('before apply with no tip amount', function(): void {
    CartSettings::set('enable_tipping', true);

    $this->tip->setMetaData(['amount' => 0]);
    $this->tip->onLoad();

    expect($this->tip->beforeApply())->toBeFalse();
});

it('before apply with invalid tip amount', function(): void {
    CartSettings::set('enable_tipping', true);

    $this->tip->setMetaData(['amount' => 'invalid']);
    $this->tip->onLoad();

    $this->tip->beforeApply();

    expect($this->tip->getMetaData('amount'))->toBeNull();
});

it('gets actions with fixed tip amount', function(): void {
    CartSettings::set('enable_tipping', true);
    CartSettings::set('tip_value_type', 'F');

    $this->tip->setMetaData(['amount' => 10, 'isCustom' => false]);
    $this->tip->onLoad();

    expect($this->tip->getActions())->toBe([
        ['value' => '+10', 'valuePrecision' => 2],
    ]);
});

it('gets actions with percentage tip amount', function(): void {
    CartSettings::set('enable_tipping', true);
    CartSettings::set('tip_value_type', 'P');

    $this->tip->setMetaData(['amount' => 10, 'isCustom' => false]);
    $this->tip->onLoad();

    expect($this->tip->getActions())->toBe([
        ['value' => '+10%', 'valuePrecision' => 2],
    ]);
});

it('gets actions with custom tip amount', function(): void {
    CartSettings::set('enable_tipping', true);
    CartSettings::set('tip_value_type', 'F');

    $this->tip->setMetaData(['amount' => 10, 'isCustom' => true]);
    $this->tip->onLoad();

    expect($this->tip->getActions())->toBe([
        ['value' => '+10', 'valuePrecision' => 2],
    ]);
});
