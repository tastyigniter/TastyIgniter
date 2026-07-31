<?php

declare(strict_types=1);

namespace Naxas\RestaurantOps\Integrations;

use Igniter\PayRegister\Models\Payment;

final class PaymentAdapter extends OfficialModelAdapter
{
    public function modelClass(): string
    {
        return Payment::class;
    }
}
