<?php

declare(strict_types=1);

namespace Igniter\PayRegister\Tests\Models;

use Igniter\Flame\Database\Traits\Purgeable;
use Igniter\Flame\Database\Traits\Sortable;
use Igniter\Flame\Exception\ApplicationException;
use Igniter\PayRegister\Classes\PaymentGateways;
use Igniter\PayRegister\Models\Payment;
use Igniter\PayRegister\Models\PaymentProfile;
use Igniter\PayRegister\Tests\Payments\Fixtures\TestPayment;
use Igniter\System\Models\Concerns\Defaultable;
use Igniter\System\Models\Concerns\Switchable;
use Igniter\User\Models\Customer;
use Mockery;

beforeEach(function(): void {
    $this->payment = Mockery::mock(Payment::class)->makePartial();
    $this->customer = Mockery::mock(Customer::class)->makePartial();
    $this->gatewayManager = Mockery::mock(PaymentGateways::class);
});

it('returns dropdown options for enabled payments', function(): void {
    $this->payment->shouldReceive('whereIsEnabled->dropdown')
        ->with('name', 'code')
        ->andReturn(['option1' => 'value1']);

    $result = $this->payment->getDropdownOptions();

    expect($result)->toBe(['option1' => 'value1']);
});

it('returns list of enabled payments with descriptions', function(): void {
    $result = Payment::listDropdownOptions();

    expect($result->toArray())->toBe(['cod' => ['Cash On Delivery', 'Pay with cash when you pick up your order or when is delivered']]);
});

it('returns true if onboarding is complete', function(): void {
    Payment::factory()->create(['status' => 1]);

    $result = Payment::onboardingIsComplete();

    expect($result)->toBeTrue();
});

it('returns false if onboarding is not complete', function(): void {
    Payment::query()->update(['status' => 0]);

    $result = Payment::onboardingIsComplete();

    expect($result)->toBeFalse();
});

it('lists gateways from gateway manager', function(): void {
    $this->payment->gatewayManager = $this->gatewayManager
        ->shouldReceive('listGateways')
        ->andReturn(['code1' => ['code' => 'code1', 'name' => 'Gateway 1']]);

    $result = $this->payment->listGateways();

    expect($result)->toBe([
        'cod' => 'lang:igniter.payregister::default.cod.text_payment_title',
        'paypalexpress' => 'lang:igniter.payregister::default.paypal.text_payment_title',
        'authorizenetaim' => 'lang:igniter.payregister::default.authorize_net_aim.text_payment_title',
        'stripe' => 'lang:igniter.payregister::default.stripe.text_payment_title',
        'mollie' => 'lang:igniter.payregister::default.mollie.text_payment_title',
        'square' => 'lang:igniter.payregister::default.square.text_payment_title',
    ]);
});

it('sets code attribute with slug format', function(): void {
    $this->payment->setCodeAttribute('Test Code');

    expect($this->payment->code)->toBe('test_code');
});

it('purges config fields and returns data', function(): void {
    $paymentMethod = Payment::factory()->create();
    $paymentMethod->applyGatewayClass();

    $paymentMethod->test_field = 'value1';

    $result = $paymentMethod->purgeConfigFields();

    expect($result)->toBe(['test_field' => 'value1'])
        ->and($paymentMethod->getAttributes())->not->toHaveKey('test_field');
});

it('applies gateway class if class exists', function(): void {
    $this->payment->class_name = TestPayment::class;
    $this->payment->shouldReceive('isClassExtendedWith')->with(TestPayment::class)->andReturn(false);
    $this->payment->shouldReceive('extendClassWith')->with(TestPayment::class);

    $result = $this->payment->applyGatewayClass();

    expect($result)->toBeTrue()
        ->and($this->payment->class_name)->toBe(TestPayment::class);
});

it('does not apply gateway class if class does not exist', function(): void {
    $this->payment->class_name = 'NonExistingClass';

    $result = $this->payment->applyGatewayClass();

    expect($result)->toBeFalse()
        ->and($this->payment->class_name)->toBeNull();
});

it('syncs all payment gateways when none exist in the database', function(): void {
    Payment::query()->delete();

    Payment::syncAll();

    $payments = Payment::all();

    expect($payments->count())->toBeGreaterThan(0);
});

it('finds payment profile for customer', function(): void {
    $this->customer->customer_id = 1;

    $result = $this->payment->findPaymentProfile($this->customer);

    expect($result)->toBeNull();
});

it('returns null if customer is not provided for finding payment profile', function(): void {
    $result = $this->payment->findPaymentProfile(null);

    expect($result)->toBeNull();
});

it('initializes new payment profile for customer', function(): void {
    $this->customer->customer_id = 1;

    $result = $this->payment->initPaymentProfile($this->customer);

    expect($result->customer_id)->toBe(1)
        ->and($result->payment_id)->toBe($this->payment->payment_id);
});

it('returns true if payment profile exists for customer', function(): void {
    $this->payment->shouldReceive('getGatewayObject->paymentProfileExists')->with($this->customer)->andReturn(true);

    $result = $this->payment->paymentProfileExists($this->customer);

    expect($result)->toBeTrue();
});

it('returns false if payment profile does not exist for customer', function(): void {
    $this->payment->shouldReceive('getGatewayObject->paymentProfileExists')->with($this->customer)->andReturn(null);
    $this->payment->shouldReceive('findPaymentProfile')->with($this->customer)->andReturn(true);

    $result = $this->payment->paymentProfileExists($this->customer);

    expect($result)->toBeTrue();
});

it('deletes payment profile for customer', function(): void {
    $profile = Mockery::mock(PaymentProfile::class);
    $this->payment->shouldReceive('findPaymentProfile')->once()->with($this->customer)->andReturn($profile);
    $this->payment->shouldReceive('getGatewayObject->deletePaymentProfile')->once()->with($this->customer, $profile);
    $profile->shouldReceive('delete');

    $this->payment->deletePaymentProfile($this->customer);
});

it('throws exception if payment profile not found for customer', function(): void {
    $gateway = Mockery::mock(TestPayment::class);
    $this->payment->shouldReceive('getGatewayObject')->with()->andReturn($gateway);
    $this->payment->shouldReceive('findPaymentProfile')->with($this->customer)->andReturn(null);

    $this->expectException(ApplicationException::class);
    $this->expectExceptionMessage(lang('igniter.user::default.customers.alert_customer_payment_profile_not_found'));

    $this->payment->deletePaymentProfile($this->customer);
});

it('configures payment model correctly', function(): void {
    $payment = new Payment;

    expect(class_uses_recursive($payment))
        ->toContain(Defaultable::class)
        ->toContain(Purgeable::class)
        ->toContain(Sortable::class)
        ->toContain(Switchable::class)
        ->and($payment->getTable())->toBe('payments')
        ->and($payment->getKeyName())->toBe('payment_id')
        ->and($payment->timestamps)->toBeTrue()
        ->and($payment->getCasts())->toHaveKeys(['data', 'priority'])
        ->and($payment->getFillable())->toBe(['name', 'code', 'class_name', 'description', 'data', 'priority', 'status', 'is_default'])
        ->and($payment->getMorphClass())->toBe('payments')
        ->and($payment->getPurgeableAttributes())->toContain('payment');
});
