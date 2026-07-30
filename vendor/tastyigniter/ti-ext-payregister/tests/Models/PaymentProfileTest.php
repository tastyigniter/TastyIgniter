<?php

declare(strict_types=1);

namespace Igniter\PayRegister\Tests\Models;

use Igniter\PayRegister\Models\PaymentProfile;
use Igniter\User\Models\Customer;
use Mockery;

beforeEach(function(): void {
    $this->paymentProfile = new PaymentProfile;
    $this->customer = Mockery::mock(Customer::class)->makePartial();
});

it('sets profile data and saves the model', function(): void {
    $profileData = ['card_id' => '123', 'customer_id' => '456'];
    $this->paymentProfile->setProfileData($profileData);

    expect($this->paymentProfile->profile_data)->toBe($profileData);
});

it('returns true if profile data contains required fields', function(): void {
    $this->paymentProfile->profile_data = ['card_id' => '123', 'customer_id' => '456'];

    expect($this->paymentProfile->hasProfileData())->toBeTrue();
});

it('returns false if profile data does not contain required fields', function(): void {
    $this->paymentProfile->profile_data = ['card_id' => '123'];

    expect($this->paymentProfile->hasProfileData())->toBeFalse();
});

it('makes the profile primary and updates other profiles', function(): void {
    $paymentProfile = PaymentProfile::factory()->create([
        'is_primary' => false,
    ]);

    $paymentProfile->makePrimary();

    expect(PaymentProfile::where('payment_profile_id', $paymentProfile->getKey())->first())->is_primary->toBeTrue();
});

it('returns the primary profile for a customer', function(): void {
    $paymentProfile = PaymentProfile::factory()->create([
        'customer_id' => 1,
        'is_primary' => true,
    ]);

    $this->customer->customer_id = 1;

    expect(PaymentProfile::getPrimary($this->customer)->getKey())->toBe($paymentProfile->getKey());
});

it('returns the first profile if no primary profile exists', function(): void {
    $paymentProfile = PaymentProfile::factory()->create([
        'customer_id' => 1,
        'is_primary' => false,
    ]);

    $this->customer->customer_id = 1;

    expect(PaymentProfile::getPrimary($this->customer)->getKey())->toBe($paymentProfile->getKey());
});

it('returns true if customer has a profile', function(): void {
    PaymentProfile::factory()->create([
        'customer_id' => 1,
        'is_primary' => false,
    ]);

    $this->customer->customer_id = 1;

    expect(PaymentProfile::customerHasProfile($this->customer))->toBeTrue();
});

it('returns false if customer does not have a profile', function(): void {
    $this->customer->customer_id = 1;

    expect(PaymentProfile::customerHasProfile($this->customer))->toBeFalse();
});
