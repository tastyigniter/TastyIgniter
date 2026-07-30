<?php

declare(strict_types=1);

namespace Igniter\PayRegister\Tests\Concerns;

use Igniter\Cart\Models\Order;
use Igniter\PayRegister\Classes\BasePaymentGateway;
use Igniter\PayRegister\Concerns\WithPaymentProfile;
use Igniter\PayRegister\Models\Payment;
use Igniter\PayRegister\Models\PaymentProfile;
use Igniter\User\Models\Customer;
use LogicException;
use Mockery;

beforeEach(function(): void {
    $this->customer = Customer::factory()->create();
    $this->order = Mockery::mock(Order::class);
    $this->profile = Mockery::mock(PaymentProfile::class);
    $payment = Mockery::mock(Payment::class);
    $this->trait = new class($payment) extends BasePaymentGateway
    {
        use WithPaymentProfile;

        public function defineFieldsConfig(): string
        {
            return __DIR__.'/../_fixtures/fields';
        }
    };
});

it('returns false when supportsPaymentProfiles is not implemented', function(): void {
    $result = $this->trait->supportsPaymentProfiles();

    expect($result)->toBeFalse();
});

it('returns null when paymentProfileExists is not implemented', function(): void {
    $result = $this->trait->paymentProfileExists($this->customer);

    expect($result)->toBeNull();
});

it('throws exception when updatePaymentProfile is not implemented', function(): void {
    $this->expectException(LogicException::class);
    $this->expectExceptionMessage('Method updatePaymentProfile must be implemented on your custom payment class.');

    $this->trait->updatePaymentProfile($this->customer, []);
});

it('throws exception when deletePaymentProfile is not implemented', function(): void {
    $this->expectException(LogicException::class);
    $this->expectExceptionMessage('Method deletePaymentProfile must be implemented on your custom payment class.');

    $this->trait->deletePaymentProfile($this->customer, $this->profile);
});

it('throws exception when payFromPaymentProfile is not implemented', function(): void {
    $this->expectException(LogicException::class);
    $this->expectExceptionMessage('Method payFromPaymentProfile must be implemented on your custom payment class.');

    $this->trait->payFromPaymentProfile($this->order, []);
});
