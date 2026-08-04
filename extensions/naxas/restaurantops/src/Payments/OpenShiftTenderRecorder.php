<?php

declare(strict_types=1);

namespace Naxas\RestaurantOps\Payments;

use Naxas\RestaurantOps\Models\CashierShift;
use Naxas\RestaurantOps\Payments\Contracts\ShiftTenderRecorder;
use Naxas\RestaurantOps\Payments\Exceptions\PaymentException;
use Naxas\RestaurantOps\Shifts\ShiftStatus;

final class OpenShiftTenderRecorder implements ShiftTenderRecorder
{
    public function assertSettleable(CashierShift $shift, int $actorId, int $locationId): void
    {
        if ($shift->status !== ShiftStatus::Open || (int) $shift->staff_id !== $actorId || (int) $shift->location_id !== $locationId) {
            throw PaymentException::forbidden('payment_open_shift_required', 'The original cashier shift at this location must be open.');
        }
    }
}
