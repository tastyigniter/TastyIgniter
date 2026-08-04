<?php

declare(strict_types=1);

namespace Naxas\RestaurantOps\Payments\Contracts;

use Naxas\RestaurantOps\Models\CashierShift;

interface ShiftTenderRecorder
{
    public function assertSettleable(CashierShift $shift, int $actorId, int $locationId): void;
}
