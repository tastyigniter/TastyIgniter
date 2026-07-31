<?php

declare(strict_types=1);

namespace Naxas\RestaurantOps\Shifts\Contracts;

use Naxas\RestaurantOps\Models\CashierShift;

interface ShiftClosingWarningProvider
{
    /** @return array<int, array<string, mixed>> */
    public function warnings(CashierShift $shift): array;
}
