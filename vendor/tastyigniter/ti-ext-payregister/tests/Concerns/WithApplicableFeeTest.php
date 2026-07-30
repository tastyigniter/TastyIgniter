<?php

declare(strict_types=1);

namespace Igniter\PayRegister\Tests\Concerns;

use Igniter\Cart\Models\Order;
use Igniter\Flame\Exception\ApplicationException;
use Igniter\PayRegister\Classes\BasePaymentGateway;
use Igniter\PayRegister\Concerns\WithApplicableFee;
use Igniter\PayRegister\Models\Payment;

beforeEach(function(): void {
    $this->order = Order::factory()->create([
        'payment' => 'test_code',
        'order_total' => 110.00,
    ]);
    $this->payment = Payment::factory()->create([
        'code' => 'test_code',
    ]);
    $this->payment->order_total = 100.00;
    $this->order->payment_method = $this->payment;
    $this->trait = new class($this->payment) extends BasePaymentGateway
    {
        use WithApplicableFee;

        public function defineFieldsConfig(): string
        {
            return __DIR__.'/../_fixtures/fields';
        }

        public function testValidatePaymentMethod($order, $host): void
        {
            $this->validatePaymentMethod($order, $host);
        }

        public function validatesApplicable(Order $order): void
        {
            $this->validateApplicableFee($order, $this->model);
        }
    };
});

it('validates payment method successfully', function(): void {
    $this->trait->testValidatePaymentMethod($this->order, $this->payment);

    expect(true)->toBeTrue();
});

it('validates applicable fee successfully', function(): void {
    $this->trait->validatesApplicable($this->order);

    expect(true)->toBeTrue();
});

it('throws exception if payment method not found', function(): void {
    $this->order->payment_method = null;

    $this->expectException(ApplicationException::class);
    $this->expectExceptionMessage('Payment method not found');

    $this->trait->validatesApplicable($this->order);
});

it('throws exception if payment method code does not match', function(): void {
    $clonedPayment = clone $this->payment;
    $clonedPayment->code = 'another_code';
    $this->order->payment_method = $clonedPayment;

    $this->expectException(ApplicationException::class);
    $this->expectExceptionMessage('Payment method not found');

    $this->trait->validatesApplicable($this->order);
});

it('throws exception if order total is not applicable', function(): void {
    $this->order->order_total = 90.00;

    $this->expectException(ApplicationException::class);
    $this->expectExceptionMessage('You need to spend £100.00 or more to pay with '.$this->payment->name);

    $this->trait->validatesApplicable($this->order);
});

it('returns true if payment type is applicable for specified order amount', function(): void {
    $result = $this->trait->isApplicable(150.00, $this->payment);

    expect($result)->toBeTrue();
});

it('returns false if payment type is not applicable for specified order amount', function(): void {
    $this->payment->order_total = 150.00;

    $result = $this->trait->isApplicable(100.00, $this->payment);

    expect($result)->toBeFalse();
});

it('returns true if payment type has additional fee', function(): void {
    $this->payment->order_fee = 10.00;

    $result = $this->trait->hasApplicableFee($this->payment);

    expect($result)->toBeTrue();
});

it('returns false if payment type does not have additional fee', function(): void {
    $this->payment->order_fee = 0.00;

    $result = $this->trait->hasApplicableFee($this->payment);

    expect($result)->toBeFalse();
});

it('returns formatted applicable fee as percentage', function(): void {
    $this->payment->order_fee_type = 2;
    $this->payment->order_fee = 10.00;

    $result = $this->trait->getFormattedApplicableFee($this->payment);

    expect($result)->toBe('10%');
});

it('returns formatted applicable fee as currency', function(): void {
    $this->payment->order_fee_type = 1;
    $this->payment->order_fee = 10.00;

    $result = $this->trait->getFormattedApplicableFee($this->payment);

    expect($result)->toBe('£10.00');
});
