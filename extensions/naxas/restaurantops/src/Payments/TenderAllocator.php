<?php

declare(strict_types=1);

namespace Naxas\RestaurantOps\Payments;

use Naxas\RestaurantOps\Payments\Exceptions\PaymentException;

final class TenderAllocator
{
    public function allocate(string $outstanding, array $rows, bool $requireReferences = true): array
    {
        $remaining = Money::minor($outstanding);
        if ($remaining <= 0 || $rows === []) {
            throw new PaymentException('payment_tenders_invalid', 'At least one tender is required.');
        } $result = [];
        foreach (array_values($rows) as $i => $row) {
            $method = (string) ($row['method'] ?? '');
            if (! in_array($method, ['cash', 'card', 'mobile'], true)) {
                throw new PaymentException('payment_method_invalid', 'Tender method is unsupported.');
            } $received = Money::minor($row['amount'] ?? '');
            if ($received <= 0) {
                throw new PaymentException('payment_amount_invalid', 'Tender amount must be greater than zero.');
            } $reference = trim((string) ($row['reference'] ?? ''));
            if ($requireReferences && $method !== 'cash' && $reference === '') {
                throw new PaymentException('payment_reference_required', 'Card and mobile tenders require a reference.');
            } if (strlen($reference) > 191) {
                throw new PaymentException('payment_reference_invalid', 'Tender reference is too long.');
            } $last = $i === count($rows) - 1;
            if ($method !== 'cash' && $received > $remaining) {
                throw new PaymentException('payment_non_cash_overpayment', 'Non-cash tender cannot exceed the remaining amount.');
            } if ($method === 'cash' && $received > $remaining && ! $last) {
                throw new PaymentException('payment_cash_overpayment_order', 'Over-tendered cash must be the final tender.');
            } $applied = min($received, $remaining);
            $change = $method === 'cash' ? $received - $applied : 0;
            $remaining -= $applied;
            $result[] = ['method' => $method, 'provider_code' => trim((string) ($row['provider'] ?? '')) ?: null, 'reference' => $reference ?: null, 'note' => trim((string) ($row['note'] ?? '')) ?: null, 'amount_received' => Money::decimal($received), 'amount_applied' => Money::decimal($applied), 'change_amount' => Money::decimal($change), 'status' => 'applied'];
        } if ($remaining !== 0) {
            throw new PaymentException('payment_underpaid', 'Tender allocations must settle the outstanding amount exactly.');
        }

        return $result;
    }
}
