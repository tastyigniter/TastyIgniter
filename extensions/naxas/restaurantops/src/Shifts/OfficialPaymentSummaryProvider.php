<?php

declare(strict_types=1);

namespace Naxas\RestaurantOps\Shifts;

use Illuminate\Support\Facades\Schema;
use Naxas\RestaurantOps\Models\CashierShift;
use Naxas\RestaurantOps\Shifts\Contracts\PaymentSummaryProvider;

final class OfficialPaymentSummaryProvider implements PaymentSummaryProvider
{
    public function summarize(CashierShift $shift): array
    {
        $available = Schema::hasTable('orders') && Schema::hasTable('payment_logs');

        return [
            'provider_status' => $available ? 'partial' : 'unavailable',
            'verified' => false,
            'source' => $available ? 'tastyigniter_orders_payment_logs' : 'deferred',
            'reason' => 'Official records have no reliable shift attribution, normalized tender class, or settled/refunded amount.',
            'cash_sales' => '0.0000', 'card_sales' => '0.0000', 'mobile_banking_sales' => '0.0000',
            'other_sales' => '0.0000', 'cash_refunds' => '0.0000', 'card_refunds' => '0.0000',
            'mobile_banking_refunds' => '0.0000', 'other_refunds' => '0.0000',
            'failed_payments' => 0, 'voided_payments' => 0, 'unpaid_order_amount' => null,
            'total_paid_sales' => null, 'total_refunds' => null,
        ];
    }
}
