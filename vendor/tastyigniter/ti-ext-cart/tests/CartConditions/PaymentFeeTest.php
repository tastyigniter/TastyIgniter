<?php

declare(strict_types=1);

use Igniter\Cart\CartConditions\PaymentFee;
use Igniter\PayRegister\Models\Payment;

beforeEach(function(): void {
    $this->paymentFee = new PaymentFee([
        'label' => 'Test Fee',
        'metaData' => ['code' => 'test'],
    ]);
});

it('gets label with percentage fee', function(): void {
    Payment::factory()->create([
        'code' => 'test',
        'data' => [
            'order_fee_type' => 2,
            'order_fee' => 10,
        ],
    ]);

    $this->paymentFee->beforeApply();

    expect($this->paymentFee->getLabel())->toBe('Test Fee [10%]');
});

it('gets label without percentage fee', function(): void {
    Payment::factory()->create([
        'code' => 'test',
        'data' => [
            'order_fee_type' => 1,
            'order_fee' => 10,
        ],
    ]);

    $this->paymentFee->beforeApply();

    expect($this->paymentFee->getLabel())->toBe('Test Fee');
});

it('before apply with no payment code', function(): void {
    $paymentFee = new PaymentFee(['label' => 'Test Fee']);

    expect($paymentFee->beforeApply())->toBeFalse();
});

it('before apply with no fee', function(): void {
    Payment::factory()->create([
        'code' => 'test',
        'data' => [
            'order_fee_type' => 1,
            'order_fee' => 0,
        ],
    ]);

    expect($this->paymentFee->beforeApply())->toBeFalse();
});

it('gets actions with percentage fee', function(): void {
    Payment::factory()->create([
        'code' => 'test',
        'data' => [
            'order_fee_type' => 2,
            'order_fee' => 10,
        ],
    ]);

    $this->paymentFee->beforeApply();

    expect($this->paymentFee->getActions())->toBe([['value' => '+10%']]);
});

it('gets actions without percentage fee', function(): void {
    Payment::factory()->create([
        'code' => 'test',
        'data' => [
            'order_fee_type' => 1,
            'order_fee' => 10,
        ],
    ]);

    $this->paymentFee->beforeApply();

    expect($this->paymentFee->getActions())->toBe([['value' => '+10']]);
});
