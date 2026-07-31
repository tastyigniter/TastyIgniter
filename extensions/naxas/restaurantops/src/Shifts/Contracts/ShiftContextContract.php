<?php

declare(strict_types=1);

namespace Naxas\RestaurantOps\Shifts\Contracts;

use Naxas\RestaurantOps\Models\CashierShift;

interface ShiftContextContract
{
    public function currentForStaff(int $staffId): ?CashierShift;

    public function requireOpenShift(int $staffId): CashierShift;

    public function open(mixed $staff, string $openingCash, ?string $terminalCode = null, ?string $note = null): CashierShift;

    /** @return array<string, mixed> */
    public function calculateSummary(CashierShift $shift): array;
}
