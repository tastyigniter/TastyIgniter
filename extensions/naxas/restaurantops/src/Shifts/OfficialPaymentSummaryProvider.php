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
        if (! Schema::hasTable('naxas_restaurant_ops_pos_payment_tenders')) {
            return ['provider_status' => 'unavailable', 'verified' => false, 'source' => 'deferred', 'reason' => 'POS tender tables are unavailable', 'cash_sales' => '0.0000', 'card_sales' => '0.0000', 'mobile_banking_sales' => '0.0000', 'other_sales' => '0.0000', 'cash_refunds' => '0.0000', 'card_refunds' => '0.0000', 'mobile_banking_refunds' => '0.0000', 'other_refunds' => '0.0000', 'failed_payments' => 0, 'voided_payments' => 0, 'unpaid_order_amount' => null, 'total_paid_sales' => null, 'total_refunds' => null];
        } $base = \DB::table('naxas_restaurant_ops_pos_payment_tenders as t')->join('naxas_restaurant_ops_pos_payments as p', 'p.id', '=', 't.pos_payment_id')->where('p.cashier_shift_id', $shift->getKey())->where('p.status', 'paid');
        $sums = (clone $base)->selectRaw("SUM(CASE WHEN t.method='cash' THEN t.amount_applied ELSE 0 END) cash_sales, SUM(CASE WHEN t.method='card' THEN t.amount_applied ELSE 0 END) card_sales, SUM(CASE WHEN t.method='mobile' THEN t.amount_applied ELSE 0 END) mobile_sales, COUNT(*) tender_count")->first();
        $total = Money::add((string) ($sums->cash_sales ?? 0), (string) ($sums->card_sales ?? 0), (string) ($sums->mobile_sales ?? 0));

        return ['provider_status' => 'available', 'verified' => true, 'source' => 'restaurant_ops_tender_ledger', 'reason' => null, 'cash_sales' => Money::normalize((string) ($sums->cash_sales ?? 0)), 'card_sales' => Money::normalize((string) ($sums->card_sales ?? 0)), 'mobile_banking_sales' => Money::normalize((string) ($sums->mobile_sales ?? 0)), 'other_sales' => '0.0000', 'cash_refunds' => '0.0000', 'card_refunds' => '0.0000', 'mobile_banking_refunds' => '0.0000', 'other_refunds' => '0.0000', 'failed_payments' => \DB::table('naxas_restaurant_ops_pos_payments')->where('cashier_shift_id', $shift->getKey())->where('status', 'payment_failed')->count(), 'voided_payments' => 0, 'unpaid_order_amount' => null, 'total_paid_sales' => $total, 'total_refunds' => '0.0000', 'tender_count' => (int) ($sums->tender_count ?? 0), 'payment_count' => \DB::table('naxas_restaurant_ops_pos_payments')->where('cashier_shift_id', $shift->getKey())->where('status', 'paid')->count(), 'reversed_payment_count' => \DB::table('naxas_restaurant_ops_pos_payments')->where('cashier_shift_id', $shift->getKey())->where('status', 'payment_reversed')->count()];
    }
}
