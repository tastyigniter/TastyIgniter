<?php

declare(strict_types=1);

namespace Igniter\PayRegister\Concerns;

use Igniter\Cart\Models\Order;
use Igniter\PayRegister\Models\PaymentProfile;
use Igniter\User\Models\Customer;
use LogicException;

trait WithPaymentProfile
{
    /**
     * This method should return TRUE if the gateway supports user payment profiles.
     * The payment gateway must implement the updatePaymentProfile(), deletePaymentProfile() and payFromPaymentProfile() methods if this method returns true.
     */
    public function supportsPaymentProfiles(): bool
    {
        return false;
    }

    public function paymentProfileExists(Customer $customer): ?bool
    {
        return null;
    }

    /**
     * Creates a customer profile on the payment gateway or update if the profile already exists.
     */
    public function updatePaymentProfile(Customer $customer, array $data = []): PaymentProfile
    {
        throw new LogicException('Method updatePaymentProfile must be implemented on your custom payment class.');
    }

    /**
     * Deletes a customer payment profile from the payment gateway.
     */
    public function deletePaymentProfile(Customer $customer, PaymentProfile $profile)
    {
        throw new LogicException('Method deletePaymentProfile must be implemented on your custom payment class.');
    }

    /**
     * Creates a payment transaction from an existing payment profile.
     */
    public function payFromPaymentProfile(Order $order, array $data = [])
    {
        throw new LogicException('Method payFromPaymentProfile must be implemented on your custom payment class.');
    }
}
