<?php

declare(strict_types=1);

namespace Naxas\RestaurantOps\Shifts\Contracts;

use Naxas\RestaurantOps\Models\CashierShift;

interface PaymentSummaryProvider
{
    /** @return array<string, mixed> */
    public function summarize(CashierShift $shift): array;
}
