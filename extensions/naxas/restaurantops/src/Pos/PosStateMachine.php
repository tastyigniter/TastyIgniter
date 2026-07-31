<?php

declare(strict_types=1);

namespace Naxas\RestaurantOps\Pos;

use Naxas\RestaurantOps\Pos\Exceptions\PosException;

final class PosStateMachine
{
    private const TRANSITIONS = [
        PosOrderStatus::DRAFT => [PosOrderStatus::HELD, PosOrderStatus::ACTIVE, PosOrderStatus::CANCELLED],
        PosOrderStatus::HELD => [PosOrderStatus::DRAFT, PosOrderStatus::CANCELLED],
        PosOrderStatus::ACTIVE => [PosOrderStatus::HELD, PosOrderStatus::KITCHEN_PENDING, PosOrderStatus::PAYMENT_PENDING, PosOrderStatus::CANCELLED],
        PosOrderStatus::KITCHEN_PENDING => [PosOrderStatus::PAYMENT_PENDING, PosOrderStatus::CANCELLED],
        PosOrderStatus::PAYMENT_PENDING => [], PosOrderStatus::CANCELLED => [],
    ];

    public function assertCan(string $from, string $to): void
    {
        if (! in_array($to, self::TRANSITIONS[$from] ?? [], true)) {
            throw PosException::conflict('pos_order_state_invalid', "POS order cannot transition from {$from} to {$to}.");
        }
    }
}
