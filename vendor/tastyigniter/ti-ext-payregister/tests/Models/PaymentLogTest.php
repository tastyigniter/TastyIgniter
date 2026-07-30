<?php

declare(strict_types=1);

namespace Igniter\PayRegister\Tests\Models;

use Carbon\Carbon;
use Igniter\Cart\Models\Order;
use Igniter\Flame\Database\Traits\Validation;
use Igniter\PayRegister\Models\Payment;
use Igniter\PayRegister\Models\PaymentLog;
use Mockery;

beforeEach(function(): void {
    $this->paymentLog = new PaymentLog;
    $this->paymentLog->payment_code = 'test_code';
    $this->paymentLog->payment_name = 'Test Payment';
    $this->paymentLog->message = 'Payment successful';
    $this->order = Order::factory()->create();
    $this->paymentLog->order_id = $this->order->getKey();
    $this->paymentMethod = Mockery::mock(Payment::class)->makePartial();
    $this->order->payment_method = $this->paymentMethod;
});

it('logs a successful payment attempt', function(): void {
    $this->paymentMethod->code = 'test_code';
    $this->paymentMethod->name = 'Test Payment';

    PaymentLog::logAttempt($this->order, 'Payment successful', true, ['request' => 'data'], ['response' => 'data'], true);

    $log = PaymentLog::where('order_id', $this->order->getKey())->first();
    expect($log->message)->toBe('Payment successful')
        ->and($log->is_success)->toBeTrue()
        ->and($log->is_refundable)->toBeTrue();
});

it('logs a failed payment attempt', function(): void {
    $this->paymentMethod->code = 'test_code';
    $this->paymentMethod->name = 'Test Payment';

    PaymentLog::logAttempt($this->order, 'Payment failed', false, ['request' => 'data'], ['response' => 'data'], false);

    $log = PaymentLog::where('order_id', $this->order->getKey())->first();
    expect($log->message)->toBe('Payment failed')
        ->and($log->is_success)->toBeFalse()
        ->and($log->is_refundable)->toBeFalse();
});

it('returns date added since attribute', function(): void {
    $this->paymentLog->created_at = Carbon::now()->subMinutes(5);

    expect($this->paymentLog->date_added_since)->toBe('5 minutes ago');
});

it('marks payment log as refund processed', function(): void {
    $this->paymentLog->order = $this->order;
    $this->paymentLog->refunded_at = null;

    $result = $this->paymentLog->markAsRefundProcessed();

    expect($result)->toBeTrue()
        ->and($this->paymentLog->refunded_at)->not->toBeNull();
});

it('does not mark payment log as refund processed if already refunded', function(): void {
    $this->paymentLog->refunded_at = Carbon::now();

    $result = $this->paymentLog->markAsRefundProcessed();

    expect($result)->toBeTrue()
        ->and($this->paymentLog->refunded_at)->not->toBeNull();
});

it('configures payment log model correctly', function(): void {
    $payment = new PaymentLog;

    expect(class_uses_recursive($payment))
        ->toContain(Validation::class)
        ->and($payment->getTable())->toBe('payment_logs')
        ->and($payment->getKeyName())->toBe('payment_log_id')
        ->and($payment->timestamps)->toBeTrue()
        ->and($payment->getAppends())->toContain('date_added_since')
        ->and($payment->getCasts())->toHaveKeys(['order_id', 'request', 'response', 'is_success', 'is_refundable', 'refunded_at'])
        ->and($payment->getMorphClass())->toBe('payment_logs')
        ->and($payment->rules)->toBe([
            'message' => 'string',
            'order_id' => 'integer',
            'payment_code' => 'string',
            'payment_name' => 'string',
            'is_success' => 'boolean',
            'request' => 'array',
            'response' => 'array',
            'is_refundable' => 'boolean',
        ]);
});
