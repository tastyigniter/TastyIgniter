<?php

declare(strict_types=1);

namespace Igniter\PayRegister\Tests\Concerns;

use Igniter\Cart\Models\Order;
use Igniter\PayRegister\Classes\BasePaymentGateway;
use Igniter\PayRegister\Concerns\WithAuthorizedPayment;
use Igniter\PayRegister\Models\Payment;
use LogicException;

beforeEach(function(): void {
    $this->order = Order::factory()->create([
        'payment' => 'test_code',
        'status_id' => 1,
    ]);
    $this->payment = Payment::factory()->create([
        'code' => 'test_code',
    ]);
    $this->order->payment_method = $this->payment;
    $this->trait = new class($this->payment) extends BasePaymentGateway
    {
        use WithAuthorizedPayment;

        public function defineFieldsConfig(): string
        {
            return __DIR__.'/../_fixtures/fields';
        }

        public function validatesApplicable(Order $order): void
        {
            $this->validateApplicableFee($order, $this->model);
        }
    };
});

it('throws exception if shouldAuthorizePayment is not implemented', function(): void {
    $this->expectException(LogicException::class);
    $this->expectExceptionMessage('Method shouldAuthorizePayment must be implemented on your custom payment class.');

    $this->trait->shouldAuthorizePayment();
});

it('returns true if order status matches capture status', function(): void {
    $this->payment->capture_status = 1;

    $result = $this->trait->shouldCapturePayment($this->order);

    expect($result)->toBeTrue();
});

it('returns false if order status does not match capture status', function(): void {
    $this->payment->capture_status = 1;
    $this->order->status_id = 2;

    $result = $this->trait->shouldCapturePayment($this->order);

    expect($result)->toBeFalse();
});

it('throws exception if captureAuthorizedPayment is not implemented', function(): void {
    $this->expectException(LogicException::class);
    $this->expectExceptionMessage('Method captureAuthorizedPayment must be implemented on your custom payment class.');

    $this->trait->captureAuthorizedPayment($this->order);
});

it('throws exception if cancelAuthorizedPayment is not implemented', function(): void {
    $this->expectException(LogicException::class);
    $this->expectExceptionMessage('Method cancelAuthorizedPayment must be implemented on your custom payment class.');

    $this->trait->cancelAuthorizedPayment($this->order);
});
