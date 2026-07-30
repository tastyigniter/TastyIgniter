<?php

declare(strict_types=1);

namespace Igniter\PayRegister\Tests\Concerns;

use Igniter\Cart\Models\Order;
use Igniter\PayRegister\Concerns\WithPaymentRefund;
use Igniter\PayRegister\Models\PaymentLog;
use LogicException;
use Mockery;

beforeEach(function(): void {
    $this->order = Mockery::mock(Order::class);
    $this->paymentLog = Mockery::mock(PaymentLog::class);
    $this->trait = Mockery::mock(WithPaymentRefund::class)->makePartial();
});

it('returns true if payment is refundable', function(): void {
    $this->paymentLog->shouldReceive('extendableGet')->with('is_refundable')->andReturn(true);

    $result = $this->trait->canRefundPayment($this->paymentLog);

    expect($result)->toBeTrue();
});

it('returns false if payment is not refundable', function(): void {
    $this->paymentLog->shouldReceive('extendableGet')->with('is_refundable')->andReturn(false);

    $result = $this->trait->canRefundPayment($this->paymentLog);

    expect($result)->toBeFalse();
});

it('throws exception if processRefundForm is not implemented', function(): void {
    $this->expectException(LogicException::class);
    $this->expectExceptionMessage('Please implement the processRefundForm method on your custom payment class.');

    $this->trait->processRefundForm([], $this->order, $this->paymentLog);
});
