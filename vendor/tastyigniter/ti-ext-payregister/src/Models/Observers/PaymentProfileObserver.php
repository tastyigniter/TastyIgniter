<?php

declare(strict_types=1);

namespace Igniter\PayRegister\Models\Observers;

use Igniter\PayRegister\Models\PaymentProfile;

class PaymentProfileObserver
{
    public function saved(PaymentProfile $paymentProfile): void
    {
        if ($paymentProfile->is_primary && $paymentProfile->wasChanged('is_primary')) {
            $paymentProfile->makePrimary();
        }
    }
}
