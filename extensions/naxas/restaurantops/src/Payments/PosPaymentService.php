<?php

declare(strict_types=1);

namespace Naxas\RestaurantOps\Payments;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Naxas\RestaurantOps\Contracts\AuditLogger;
use Naxas\RestaurantOps\Contracts\LocationContextContract;
use Naxas\RestaurantOps\Models\CashierShift;
use Naxas\RestaurantOps\Models\PosOrder;
use Naxas\RestaurantOps\Models\PosPayment;
use Naxas\RestaurantOps\Models\PosPaymentEvent;
use Naxas\RestaurantOps\Models\PosPaymentReversal;
use Naxas\RestaurantOps\Models\PosPaymentTender;
use Naxas\RestaurantOps\Models\PosReceipt;
use Naxas\RestaurantOps\Payments\Contracts\OfficialPaymentAdapter;
use Naxas\RestaurantOps\Payments\Contracts\ReceiptNumberProvider;
use Naxas\RestaurantOps\Payments\Contracts\ShiftTenderRecorder;
use Naxas\RestaurantOps\Payments\Events\PosPaymentCompleted;
use Naxas\RestaurantOps\Payments\Events\PosReceiptIssued;
use Naxas\RestaurantOps\Payments\Exceptions\PaymentException;
use Naxas\RestaurantOps\Pos\PosOrderStatus;

final class PosPaymentService
{
    public function __construct(private LocationContextContract $locations, private TenderAllocator $allocator, private OfficialPaymentAdapter $official, private ReceiptNumberProvider $numbers, private ShiftTenderRecorder $shifts, private AuditLogger $audit) {}

    public function settle(PosOrder $order, mixed $actor, array $data, string $key): PosPayment
    {
        $actorId = (int) $actor->getAuthIdentifier();
        if (trim($key) === '') {
            throw new PaymentException('payment_idempotency_key_required', 'Idempotency-Key is required.');
        } $hash = $this->hash($data);
        $prior = PosPayment::where(['cashier_staff_id' => $actorId, 'idempotency_key' => $key])->first();
        if ($prior) {
            if (! hash_equals($prior->request_hash, $hash)) {
                throw PaymentException::conflict('payment_idempotency_conflict', 'The idempotency key was used for different input.');
            }

            return $prior->load(['tenders', 'receipt']);
        }

        return DB::transaction(function () use ($order, $actorId, $data, $key, $hash) {
            $locked = PosOrder::query()->lockForUpdate()->findOrFail($order->getKey());
            $location = $this->locations->requireCurrent();
            if ($this->locations->isGlobal() || (int) $locked->location_id !== (int) $location->getKey()) {
                throw PaymentException::forbidden('payment_location_forbidden', 'Cross-location settlement is prohibited.');
            } if ((int) ($data['version'] ?? 0) !== (int) $locked->version) {
                throw PaymentException::conflict('payment_order_version_conflict', 'The POS order changed before payment.');
            } if ($locked->status !== PosOrderStatus::PAYMENT_PENDING) {
                throw PaymentException::conflict('payment_order_state_invalid', 'Only a payment-pending order can be settled.');
            } if (! $locked->order_id) {
                throw new PaymentException('payment_official_order_required', 'The linked official order is required.');
            } if (PosPayment::where('pos_order_id', $locked->getKey())->where('status', 'paid')->exists()) {
                throw PaymentException::conflict('payment_duplicate_completed', 'This order is already paid.');
            } $shift = CashierShift::query()->lockForUpdate()->findOrFail($locked->shift_id);
            $this->shifts->assertSettleable($shift, $actorId, (int) $location->getKey());
            if ((int) $locked->cashier_id !== $actorId) {
                throw PaymentException::forbidden('payment_cashier_forbidden', 'Only the order cashier may settle it.');
            } $outstanding = $this->official->outstanding((int) $locked->order_id);
            if (Money::minor($outstanding) !== Money::minor((string) $locked->outstanding_total)) {
                throw PaymentException::conflict('payment_snapshot_mismatch', 'The official outstanding amount differs from the locked POS snapshot.');
            } $tenders = $this->allocator->allocate($outstanding, (array) ($data['tenders'] ?? []), (bool) config('restaurant-ops.payment.require_reference', true));
            $change = array_sum(array_map(fn ($r) => Money::minor($r['change_amount']), $tenders));
            $payment = PosPayment::create(['pos_order_id' => $locked->getKey(), 'official_order_id' => $locked->order_id, 'location_id' => $locked->location_id, 'cashier_shift_id' => $shift->getKey(), 'cashier_staff_id' => $actorId, 'status' => 'payment_processing', 'currency_code' => config('restaurant-ops.payment.currency', 'BDT'), 'subtotal' => $locked->subtotal, 'discount_total' => $locked->discount_total, 'tax_total' => $locked->tax_total, 'delivery_total' => $locked->delivery_total, 'payable_total' => $outstanding, 'paid_total' => $outstanding, 'change_total' => Money::decimal($change), 'outstanding_before' => $outstanding, 'outstanding_after' => '0.0000', 'idempotency_key' => $key, 'request_hash' => $hash]);
            foreach ($tenders as $tender) {
                PosPaymentTender::create($tender + ['pos_payment_id' => $payment->getKey()]);
            } $this->event($payment, $actorId, 'official_sync_started', ['methods' => array_column($tenders, 'method')]);
            $reference = $this->official->synchronize($payment, ['tenders' => array_map(fn ($t) => array_intersect_key($t, array_flip(['method', 'provider_code', 'reference', 'amount_applied'])), $tenders)]);
            $receiptNo = $this->numbers->next((int) $locked->location_id, (string) ($location->location_name ?? $locked->location_id));
            $receipt = PosReceipt::create(['pos_payment_id' => $payment->getKey(), 'official_order_id' => $locked->order_id, 'receipt_number' => $receiptNo, 'location_snapshot' => ['id' => $locked->location_id, 'name' => $location->location_name ?? 'Branch', 'address' => $location->location_address ?? null, 'telephone' => $location->location_telephone ?? null], 'cashier_snapshot' => ['id' => $actorId, 'name' => $actor->staff_name ?? $actor->username ?? ('Staff '.$actorId)], 'customer_snapshot' => ['id' => $locked->customer_id, 'name' => $locked->guest_name, 'phone' => $locked->guest_phone], 'item_snapshot' => $locked->items()->get()->map(fn ($i) => ['name' => $i->configuration_payload['menu_name'] ?? 'Menu item', 'variant' => $i->configuration_payload['variant']['name'] ?? null, 'quantity' => $i->quantity, 'unit_price' => $i->unit_total, 'line_total' => $i->line_total])->all(), 'totals_snapshot' => ['subtotal' => $locked->subtotal, 'discount' => $locked->discount_total, 'tax' => $locked->tax_total, 'delivery' => $locked->delivery_total, 'grand_total' => $outstanding], 'tender_snapshot' => $tenders, 'tax_snapshot' => ['total' => $locked->tax_total], 'footer_snapshot' => ['restaurant_name' => config('restaurant-ops.payment.receipt.restaurant_name', 'Ottoman Express'), 'message' => config('restaurant-ops.payment.receipt.footer', 'Thank you.')], 'issued_at' => now()]);
            $payment->forceFill(['status' => 'paid', 'official_payment_reference' => $reference, 'receipt_number' => $receiptNo, 'paid_at' => now(), 'version' => 2])->save();
            $locked->forceFill(['status' => PosOrderStatus::PAID, 'outstanding_total' => '0.0000', 'version' => $locked->version + 1])->save();
            $this->event($payment, $actorId, 'receipt_issued', ['receipt_number' => $receiptNo]);
            $this->audit->info('restaurant_ops.payment.completed', ['payment_id' => $payment->getKey(), 'pos_order_id' => $locked->getKey(), 'official_order_id' => $locked->order_id, 'location_id' => $locked->location_id, 'shift_id' => $shift->getKey(), 'actor_id' => $actorId, 'idempotency_key' => $key]);
            DB::afterCommit(fn () => [PosPaymentCompleted::dispatch(['payment_id' => $payment->getKey(), 'pos_order_id' => $locked->getKey(), 'location_id' => $locked->location_id]), PosReceiptIssued::dispatch(['payment_id' => $payment->getKey(), 'receipt_id' => $receipt->getKey()])]);

            return $payment->load(['tenders', 'receipt']);
        }, 3);
    }

    public function print(PosPayment $payment, int $actorId, bool $reprint): PosReceipt
    {
        if ($payment->status !== 'paid') {
            throw PaymentException::conflict('receipt_payment_not_paid', 'Only paid receipts may be printed.');
        }

        return DB::transaction(function () use ($payment, $actorId, $reprint) {
            $receipt = PosReceipt::where('pos_payment_id', $payment->getKey())->lockForUpdate()->firstOrFail();
            $receipt->forceFill(['print_count' => $receipt->print_count + 1, 'last_printed_at' => now()])->save();
            $this->event($payment, $actorId, $reprint ? 'receipt_reprinted' : 'receipt_printed', ['print_count' => $receipt->print_count]);

            return $receipt;
        }, 3);
    }

    public function requestReversal(PosPayment $payment, int $actorId, string $reason): PosPaymentReversal
    {
        if (trim($reason) === '') {
            throw new PaymentException('payment_reversal_reason_required', 'A reversal reason is required.');
        } if ($payment->status !== 'paid') {
            throw PaymentException::conflict('payment_reversal_ineligible', 'Only a paid payment is eligible.');
        }

        return PosPaymentReversal::create(['pos_payment_id' => $payment->getKey(), 'requested_by' => $actorId, 'reason' => trim($reason), 'requested_at' => now()]);
    }

    public function approveReversal(PosPayment $payment, PosPaymentReversal $request, int $managerId): never
    {
        if ((int) $request->requested_by === $managerId) {
            throw PaymentException::forbidden('payment_reversal_self_approval', 'A cashier cannot approve their own reversal.');
        } throw PaymentException::conflict('payment_reversal_unsupported', 'The installed official payment API has no safe generic reversal seam; approval execution is intentionally blocked.');
    }

    private function event(PosPayment $payment, int $actor, string $type, array $payload = []): void
    {
        PosPaymentEvent::create(['pos_payment_id' => $payment->getKey(), 'event_type' => $type, 'actor_id' => $actor, 'payload' => $payload ?: null, 'correlation_id' => (string) Str::uuid(), 'occurred_at' => now()]);
    }

    private function hash(array $data): string
    {
        unset($data['payable_total'],$data['remaining']);

        return hash('sha256', json_encode($data, JSON_THROW_ON_ERROR | JSON_UNESCAPED_SLASHES));
    }
}
