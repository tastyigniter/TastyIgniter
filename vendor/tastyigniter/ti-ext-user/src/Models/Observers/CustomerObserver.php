<?php

declare(strict_types=1);

namespace Igniter\User\Models\Observers;

use Igniter\User\Models\Customer;

class CustomerObserver
{
    public function created(Customer $customer): void
    {
        $customer->saveCustomerGuestOrder();
    }

    public function saved(Customer $customer): void
    {
        $customer->restorePurgedValues();

        if ($customer->group && !$customer->group->requiresApproval() && ($customer->status && is_null($customer->is_activated))) {
            $customer->completeActivation($customer->getActivationCode());
        }

        if (array_key_exists('addresses', $customer->getAttributes())) {
            $customer->saveAddresses(array_get($customer->getAttributes(), 'addresses', []));
        }
    }

    public function deleting(Customer $customer): void
    {
        $customer->addresses()->delete();
    }
}
