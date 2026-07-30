<?php

declare(strict_types=1);

namespace Igniter\PayRegister\Tests\Payments;

use Igniter\Cart\Models\Order;
use Igniter\Flame\Exception\ApplicationException;
use Igniter\PayRegister\Models\Payment;
use Igniter\PayRegister\Payments\Cod;
use Mockery;

beforeEach(function(): void {
    $this->payment = Mockery::mock(Payment::class)->makePartial();
    $this->order = Mockery::mock(Order::class)->makePartial();
    $this->order->payment_method = $this->payment;
    $this->cod = new Cod;
});

it('returns correct payment form view', function(): void {
    expect(Cod::$paymentFormView)->toBe('igniter.payregister::_partials.cod.payment_form');
});

it('returns correct fields config', function(): void {
    expect($this->cod->defineFieldsConfig())->toBe('igniter.payregister::/models/cod');
});

it('processes payment form and updates order status', function(): void {
    $this->payment->order_status = 'processed';
    $this->payment->order_total = 100;
    $this->order->order_total = 100;
    $this->order->shouldReceive('updateOrderStatus')->with('processed', ['notify' => false])->once();
    $this->order->shouldReceive('markAsPaymentProcessed')->once();

    $this->cod->processPaymentForm([], $this->payment, $this->order);
});

it('throws exception if applicable fee validation fails', function(): void {
    $this->payment->order_status = 'processed';
    $this->payment->order_total = 200;
    $this->order->order_total = 100;

    $this->expectException(ApplicationException::class);
    $this->expectExceptionMessage('You need to spend £200.00 or more to pay with');

    $this->cod->processPaymentForm([], $this->payment, $this->order);
});
