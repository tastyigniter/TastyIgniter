<?php

declare(strict_types=1);

namespace Naxas\RestaurantOps\Shifts;

use Naxas\RestaurantOps\Shifts\Exceptions\ShiftException;

final class ShiftStateMachine
{
    private const TRANSITIONS = [
        'open' => ['closing_requested', 'force_closed', 'cancelled'],
        'closing_requested' => ['submitted', 'force_closed'],
        'submitted' => ['approved', 'rejected', 'force_closed'],
        'rejected' => ['closing_requested', 'submitted', 'force_closed'],
    ];

    public function assertCan(ShiftStatus $from, ShiftStatus $to): void
    {
        if (! in_array($to->value, self::TRANSITIONS[$from->value] ?? [], true)) {
            throw ShiftException::conflict('shift_invalid_transition', "Shift cannot transition from {$from->value} to {$to->value}.");
        }
    }
}
