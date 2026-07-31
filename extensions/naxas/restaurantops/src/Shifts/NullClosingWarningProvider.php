<?php

declare(strict_types=1);

namespace Naxas\RestaurantOps\Shifts;

use Naxas\RestaurantOps\Models\CashierShift;
use Naxas\RestaurantOps\Shifts\Contracts\ShiftClosingWarningProvider;

final class NullClosingWarningProvider implements ShiftClosingWarningProvider
{
    public function warnings(CashierShift $shift): array
    {
        return [['code' => 'payment_source_unverified', 'severity' => 'warning', 'message' => 'Current official payment data cannot be authoritatively attributed to this shift.']];
    }
}
