<?php

declare(strict_types=1);

namespace Naxas\RestaurantOps\Shifts;

use Naxas\RestaurantOps\Models\CashierShift;
use Naxas\RestaurantOps\Models\PosOrder;
use Naxas\RestaurantOps\Pos\PosOrderStatus;
use Naxas\RestaurantOps\Shifts\Contracts\ShiftClosingWarningProvider;

final class PosClosingWarningProvider implements ShiftClosingWarningProvider
{
    public function warnings(CashierShift $shift): array
    {
        $counts = PosOrder::query()->where('shift_id', $shift->getKey())->where('location_id', $shift->location_id)
            ->whereIn('status', [PosOrderStatus::DRAFT, PosOrderStatus::HELD, PosOrderStatus::ACTIVE, PosOrderStatus::KITCHEN_PENDING, PosOrderStatus::PAYMENT_PENDING])
            ->selectRaw('status, COUNT(*) as aggregate')->groupBy('status')->pluck('aggregate', 'status')->map(fn ($count) => (int) $count)->all();

        return collect($counts)->map(fn (int $count, string $status): array => ['code' => 'pos_'.$status.'_orders', 'severity' => $status === PosOrderStatus::PAYMENT_PENDING ? 'blocking' : 'warning', 'message' => "{$count} POS {$status} order(s) require handling.", 'count' => $count])->values()->all();
    }
}
