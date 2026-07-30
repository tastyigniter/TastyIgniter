<?php

declare(strict_types=1);

namespace Igniter\PayRegister\Tests\Listeners;

use Igniter\Cart\Models\Order;
use Igniter\PayRegister\Listeners\UpdatePaymentIntentSessionOnCheckout;
use Igniter\PayRegister\Models\Payment;
use Igniter\PayRegister\Payments\Stripe;
use Mockery;

beforeEach(function(): void {
    $this->listener = new UpdatePaymentIntentSessionOnCheckout;
    $this->order = Order::factory()->create();
    $this->paymentMethod = Mockery::mock(Payment::class)->makePartial();
    $this->order->payment_method = $this->paymentMethod;
});

it('does nothing if payment method is not set', function(): void {
    $this->order->payment_method = null;

    $result = $this->listener->handle($this->order);

    expect($result)->toBeNull();
});

it('does nothing if payment method is not an instance of Payment', function(): void {
    $result = $this->listener->handle($this->order);

    expect($result)->toBeNull();
});

it('does nothing if updatePaymentIntentSession method does not exist', function(): void {
    $this->paymentMethod->shouldReceive('methodExists')->with('updatePaymentIntentSession')->andReturn(false);

    $result = $this->listener->handle($this->order);

    expect($result)->toBeNull();
});

it('calls updatePaymentIntentSession if method exists', function(): void {
    $this->paymentMethod->shouldReceive('getGatewayObject')->andReturn($paymentGateway = mock(Stripe::class));
    $paymentGateway->shouldReceive('updatePaymentIntentSession')->with($this->order)->once();

    $this->listener->handle($this->order);
});
