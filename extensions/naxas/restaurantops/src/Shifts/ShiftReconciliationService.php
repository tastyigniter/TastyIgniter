<?php

declare(strict_types=1);

namespace Naxas\RestaurantOps\Shifts;

use Naxas\RestaurantOps\Models\CashierShift;
use Naxas\RestaurantOps\Shifts\Contracts\PaymentSummaryProvider;
use Naxas\RestaurantOps\Shifts\Contracts\ShiftClosingWarningProvider;

final class ShiftReconciliationService
{
    public function __construct(private readonly PaymentSummaryProvider $payments, private readonly ShiftClosingWarningProvider $warnings) {}

    /** @return array<string, mixed> */
    public function summarize(CashierShift $shift): array
    {
        $payment = $this->payments->summarize($shift);
        $totals = ['cash_in' => '0.0000', 'cash_out' => '0.0000', 'safe_drop' => '0.0000', 'petty_expense' => '0.0000', 'adjustment' => '0.0000'];
        $rows = $shift->movements()->whereNull('reversed_at')->selectRaw('type, SUM(amount) as aggregate')->groupBy('type')->pluck('aggregate', 'type');
        foreach ($rows as $type => $amount) {
            if (array_key_exists((string) $type, $totals)) {
                $totals[(string) $type] = Money::normalize((string) $amount);
            }
        }

        $expected = Money::add((string) $shift->opening_cash, (string) $payment['cash_sales'], $totals['cash_in'], $totals['adjustment']);
        $expected = Money::subtract($expected, (string) $payment['cash_refunds'], $totals['cash_out'], $totals['safe_drop'], $totals['petty_expense']);
        $warningList = $this->warnings->warnings($shift);
        $canonical = ['opening_cash' => (string) $shift->opening_cash, 'payment' => $payment, 'movements' => $totals, 'expected_cash' => $expected, 'warnings' => $warningList];

        return $canonical + [
            'order_summary' => ['status' => 'unavailable', 'reason' => 'Orders are not shift-linked in Phase 1.5.'],
            'reconciliation_hash' => hash('sha256', json_encode($canonical, JSON_THROW_ON_ERROR | JSON_UNESCAPED_SLASHES)),
        ];
    }
}
