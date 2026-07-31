<?php

declare(strict_types=1);

namespace Naxas\RestaurantOps\Shifts;

use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Naxas\RestaurantOps\Contracts\AuditLogger;
use Naxas\RestaurantOps\Contracts\LocationContextContract;
use Naxas\RestaurantOps\Models\CashierShift;
use Naxas\RestaurantOps\Models\CashMovement;
use Naxas\RestaurantOps\Models\ShiftDenomination;
use Naxas\RestaurantOps\Models\ShiftSubmission;
use Naxas\RestaurantOps\Shifts\Contracts\ShiftContextContract;
use Naxas\RestaurantOps\Shifts\Exceptions\ShiftException;

final class CashierShiftContext implements ShiftContextContract
{
    private const MOVEMENT_TYPES = ['cash_in', 'cash_out', 'safe_drop', 'petty_expense', 'adjustment'];

    public function __construct(
        private readonly LocationContextContract $locations,
        private readonly ShiftReconciliationService $reconciliation,
        private readonly ShiftStateMachine $states,
        private readonly AuditLogger $audit,
    ) {}

    public function currentForStaff(int $staffId): ?CashierShift
    {
        return CashierShift::query()->where('active_staff_id', $staffId)->first();
    }

    public function requireOpenShift(int $staffId): CashierShift
    {
        $shift = $this->currentForStaff($staffId);
        if (! $shift || $shift->status !== ShiftStatus::Open) {
            throw ShiftException::conflict('shift_not_open', 'An open shift is required.');
        }

        return $shift;
    }

    public function open(mixed $staff, string $openingCash, ?string $terminalCode = null, ?string $note = null): CashierShift
    {
        $location = $this->requireTransactionLocation();
        $staffId = (int) $staff->getAuthIdentifier();
        $cash = Money::normalize($openingCash);
        if (Money::toScaled($cash) < 0) {
            throw new ShiftException('shift_opening_cash_invalid', 'Opening cash cannot be negative.');
        }

        try {
            return DB::transaction(function () use ($staff, $staffId, $location, $cash, $terminalCode, $note): CashierShift {
                $staff->newQuery()->whereKey($staffId)->lockForUpdate()->first();
                if ($existing = CashierShift::query()->where('active_staff_id', $staffId)->lockForUpdate()->first()) {
                    throw ShiftException::conflict('shift_already_open', "Staff already has active shift {$existing->getKey()}.");
                }

                $shift = CashierShift::query()->create([
                    'location_id' => $location->getKey(), 'staff_id' => $staffId, 'active_staff_id' => $staffId,
                    'terminal_code' => $terminalCode ? trim($terminalCode) : null, 'status' => ShiftStatus::Open,
                    'opened_at' => now(), 'opening_cash' => $cash, 'opening_note' => $note,
                ]);
                $this->audit->info('restaurant_ops.shift.opened', $this->context($shift, $staffId) + ['opening_cash' => $cash]);

                return $shift;
            }, 3);
        } catch (QueryException $exception) {
            if (in_array((string) $exception->getCode(), ['23000', '23505'], true)) {
                $this->audit->warning('restaurant_ops.shift.concurrency_conflict', ['staff_id' => $staffId]);
                throw ShiftException::conflict('shift_concurrency_conflict', 'A concurrent shift open was detected.');
            }
            throw $exception;
        }
    }

    public function addMovement(CashierShift $shift, mixed $actor, string $type, string $amount, string $reasonCode, ?string $reasonText = null, ?string $idempotencyKey = null): CashMovement
    {
        $this->assertLocation($shift);
        if (! in_array($type, self::MOVEMENT_TYPES, true) || trim($reasonCode) === '') {
            throw new ShiftException('shift_cash_movement_invalid', 'A supported movement type and reason code are required.');
        }
        if ($type === 'adjustment' && ! $actor->hasPermission('Restaurant.Shifts.Approve')) {
            throw ShiftException::forbidden('shift_cash_movement_forbidden', 'Manager approval permission is required for adjustments.');
        }
        $normalized = Money::normalize($amount, true);

        return DB::transaction(function () use ($shift, $actor, $type, $normalized, $reasonCode, $reasonText, $idempotencyKey): CashMovement {
            $locked = CashierShift::query()->lockForUpdate()->findOrFail($shift->getKey());
            if ($locked->status !== ShiftStatus::Open) {
                throw ShiftException::conflict('shift_cash_movement_forbidden', 'Movements are allowed only while a shift is open.');
            }
            if ($idempotencyKey && $existing = CashMovement::query()->where('shift_id', $locked->getKey())->where('idempotency_key', $idempotencyKey)->first()) {
                return $existing;
            }
            $movement = CashMovement::query()->create([
                'shift_id' => $locked->getKey(), 'location_id' => $locked->location_id, 'type' => $type,
                'amount' => $normalized, 'reason_code' => trim($reasonCode), 'reason_text' => $reasonText,
                'created_by' => $actor->getAuthIdentifier(), 'approved_by' => $type === 'adjustment' ? $actor->getAuthIdentifier() : null,
                'occurred_at' => now(), 'idempotency_key' => $idempotencyKey,
            ]);
            $this->audit->info('restaurant_ops.shift.cash_movement_created', $this->context($locked, (int) $actor->getAuthIdentifier()) + ['movement_id' => $movement->getKey(), 'type' => $type, 'amount' => $normalized]);

            return $movement;
        }, 3);
    }

    public function reverseMovement(CashierShift $shift, CashMovement $movement, mixed $actor, string $reason): CashMovement
    {
        $this->assertLocation($shift);
        if (! $actor->hasPermission('Restaurant.Shifts.Approve') || trim($reason) === '') {
            throw ShiftException::forbidden('shift_reversal_invalid', 'Manager permission and a reversal reason are required.');
        }

        return DB::transaction(function () use ($shift, $movement, $actor, $reason): CashMovement {
            $lockedShift = CashierShift::query()->lockForUpdate()->findOrFail($shift->getKey());
            $locked = CashMovement::query()->lockForUpdate()->findOrFail($movement->getKey());
            if ($locked->shift_id !== $lockedShift->getKey() || $lockedShift->status !== ShiftStatus::Open || $locked->reversed_at) {
                throw ShiftException::conflict('shift_reversal_invalid', 'This movement cannot be reversed.');
            }
            $locked->forceFill(['reversed_at' => now(), 'reversed_by' => $actor->getAuthIdentifier(), 'reversal_reason' => trim($reason)])->save();
            $this->audit->info('restaurant_ops.shift.cash_movement_reversed', $this->context($lockedShift, (int) $actor->getAuthIdentifier()) + ['movement_id' => $locked->getKey()]);

            return $locked;
        }, 3);
    }

    public function requestClosing(CashierShift $shift, mixed $actor): array
    {
        $this->assertLocation($shift);

        return DB::transaction(function () use ($shift, $actor): array {
            $locked = CashierShift::query()->lockForUpdate()->findOrFail($shift->getKey());
            if ($locked->status === ShiftStatus::ClosingRequested) {
                return $this->calculateSummary($locked);
            }
            $this->states->assertCan($locked->status, ShiftStatus::ClosingRequested);
            $locked->forceFill(['status' => ShiftStatus::ClosingRequested, 'closing_requested_at' => now(), 'version' => $locked->version + 1])->save();
            $summary = $this->calculateSummary($locked);
            $this->audit->info('restaurant_ops.shift.closing_requested', $this->context($locked, (int) $actor->getAuthIdentifier()));

            return $summary;
        }, 3);
    }

    public function submit(CashierShift $shift, mixed $actor, ?string $countedCash, array $denominations = [], ?string $note = null): ShiftSubmission
    {
        $this->assertLocation($shift);

        return DB::transaction(function () use ($shift, $actor, $countedCash, $denominations, $note): ShiftSubmission {
            $locked = CashierShift::query()->lockForUpdate()->findOrFail($shift->getKey());
            if (! in_array($locked->status, [ShiftStatus::ClosingRequested, ShiftStatus::Rejected], true)) {
                throw ShiftException::conflict('shift_invalid_transition', 'Shift must be closing requested or rejected before submission.');
            }
            $summary = $this->calculateSummary($locked);
            $denominationTotal = $this->denominationTotal($denominations);
            if ($countedCash === null && $denominationTotal === null) {
                throw new ShiftException('shift_counted_cash_invalid', 'Counted cash or denominations are required.');
            }
            $counted = Money::normalize($countedCash ?? $denominationTotal);
            if (Money::toScaled($counted) < 0 || ($denominationTotal !== null && $counted !== $denominationTotal)) {
                throw new ShiftException('shift_counted_cash_invalid', 'Counted cash is invalid or does not match denominations.');
            }
            $revision = $locked->submission_revision + 1;
            $submission = ShiftSubmission::query()->create([
                'shift_id' => $locked->getKey(), 'revision' => $revision, 'opening_cash' => $locked->opening_cash,
                'expected_cash' => $summary['expected_cash'], 'counted_cash' => $counted,
                'variance' => Money::subtract($counted, $summary['expected_cash']),
                'payment_summary' => $summary['payment'], 'cash_movement_summary' => $summary['movements'],
                'order_summary' => $summary['order_summary'], 'open_order_warnings' => $summary['warnings'],
                'reconciliation_hash' => $summary['reconciliation_hash'], 'submitted_by' => $actor->getAuthIdentifier(), 'submitted_at' => now(),
            ]);
            foreach ($denominations as $row) {
                $denomination = Money::normalize((string) ($row['denomination'] ?? ''));
                $quantity = filter_var($row['quantity'] ?? null, FILTER_VALIDATE_INT, ['options' => ['min_range' => 0]]);
                ShiftDenomination::query()->create(['shift_submission_id' => $submission->getKey(), 'denomination' => $denomination, 'quantity' => $quantity, 'total' => Money::multiply($denomination, $quantity)]);
            }
            $locked->forceFill([
                'status' => ShiftStatus::Submitted, 'submitted_at' => $submission->submitted_at, 'submitted_by' => $actor->getAuthIdentifier(),
                'expected_cash' => $submission->expected_cash, 'counted_cash' => $counted, 'variance' => $submission->variance,
                'submission_revision' => $revision, 'reconciliation_hash' => $summary['reconciliation_hash'], 'closing_note' => $note, 'version' => $locked->version + 1,
            ])->save();
            $this->audit->info('restaurant_ops.shift.submitted', $this->context($locked, (int) $actor->getAuthIdentifier()) + ['revision' => $revision]);

            return $submission;
        }, 3);
    }

    public function approve(CashierShift $shift, mixed $manager): CashierShift
    {
        $this->assertLocation($shift);

        return DB::transaction(function () use ($shift, $manager): CashierShift {
            $locked = CashierShift::query()->lockForUpdate()->findOrFail($shift->getKey());
            if ($locked->staff_id === (int) $manager->getAuthIdentifier()) {
                $this->audit->warning('restaurant_ops.shift.self_approval_attempt', $this->context($locked, (int) $manager->getAuthIdentifier()));
                throw ShiftException::forbidden('shift_self_approval_forbidden', 'A cashier cannot approve their own shift.');
            }
            $this->states->assertCan($locked->status, ShiftStatus::Approved);
            $summary = $this->calculateSummary($locked);
            if (! hash_equals((string) $locked->reconciliation_hash, $summary['reconciliation_hash'])) {
                $this->audit->warning('restaurant_ops.shift.stale_summary', $this->context($locked, (int) $manager->getAuthIdentifier()));
                throw ShiftException::conflict('shift_summary_changed', 'Shift summary changed after submission; resubmission or force close is required.');
            }
            $this->decideLatest($locked, 'approved', $manager, null);
            $locked->forceFill(['status' => ShiftStatus::Approved, 'active_staff_id' => null, 'approved_at' => now(), 'approved_by' => $manager->getAuthIdentifier(), 'version' => $locked->version + 1])->save();
            $this->audit->info('restaurant_ops.shift.approved', $this->context($locked, (int) $manager->getAuthIdentifier()));

            return $locked;
        }, 3);
    }

    public function reject(CashierShift $shift, mixed $manager, string $reason): CashierShift
    {
        return $this->managerDecision($shift, $manager, ShiftStatus::Rejected, $reason, 'rejected');
    }

    public function forceClose(CashierShift $shift, mixed $manager, string $reason): CashierShift
    {
        $this->assertLocation($shift);
        if (trim($reason) === '') {
            throw new ShiftException('shift_force_close_reason_required', 'Force-close reason is required.');
        }

        return DB::transaction(function () use ($shift, $manager, $reason): CashierShift {
            $locked = CashierShift::query()->lockForUpdate()->findOrFail($shift->getKey());
            $this->states->assertCan($locked->status, ShiftStatus::ForceClosed);
            if ($locked->status === ShiftStatus::Submitted) {
                $this->decideLatest($locked, 'force_closed', $manager, $reason);
            }
            $summary = $this->calculateSummary($locked);
            $locked->forceFill(['status' => ShiftStatus::ForceClosed, 'active_staff_id' => null, 'force_closed_at' => now(), 'force_closed_by' => $manager->getAuthIdentifier(), 'force_close_reason' => trim($reason), 'expected_cash' => $summary['expected_cash'], 'reconciliation_hash' => $summary['reconciliation_hash'], 'version' => $locked->version + 1])->save();
            $this->audit->warning('restaurant_ops.shift.force_closed', $this->context($locked, (int) $manager->getAuthIdentifier()));

            return $locked;
        }, 3);
    }

    public function calculateSummary(CashierShift $shift): array
    {
        return $this->reconciliation->summarize($shift);
    }

    public function assertLocation(CashierShift $shift): void
    {
        if ($this->locations->isGlobal()) {
            throw ShiftException::conflict('shift_global_mode_not_allowed', 'Select a concrete branch for shift operations.');
        }
        if ($this->locations->currentId() !== $shift->location_id) {
            $this->audit->warning('restaurant_ops.shift.cross_location_attempt', ['shift_id' => $shift->getKey(), 'shift_location_id' => $shift->location_id, 'context_location_id' => $this->locations->currentId()]);
            throw ShiftException::forbidden('shift_location_forbidden', 'Shift belongs to another location.');
        }
    }

    private function managerDecision(CashierShift $shift, mixed $manager, ShiftStatus $to, string $reason, string $decision): CashierShift
    {
        $this->assertLocation($shift);
        if (trim($reason) === '') {
            throw new ShiftException('shift_decision_reason_required', 'Decision reason is required.');
        }

        return DB::transaction(function () use ($shift, $manager, $to, $reason, $decision): CashierShift {
            $locked = CashierShift::query()->lockForUpdate()->findOrFail($shift->getKey());
            if ($locked->staff_id === (int) $manager->getAuthIdentifier()) {
                throw ShiftException::forbidden('shift_self_approval_forbidden', 'A cashier cannot decide their own shift.');
            }
            $this->states->assertCan($locked->status, $to);
            $this->decideLatest($locked, $decision, $manager, $reason);
            $locked->forceFill(['status' => $to, 'rejected_at' => now(), 'rejected_by' => $manager->getAuthIdentifier(), 'rejection_reason' => trim($reason), 'version' => $locked->version + 1])->save();
            $this->audit->info('restaurant_ops.shift.rejected', $this->context($locked, (int) $manager->getAuthIdentifier()));

            return $locked;
        }, 3);
    }

    private function decideLatest(CashierShift $shift, string $decision, mixed $manager, ?string $reason): void
    {
        $submission = ShiftSubmission::query()->where('shift_id', $shift->getKey())->where('revision', $shift->submission_revision)->lockForUpdate()->first();
        if (! $submission) {
            throw ShiftException::conflict('shift_submission_required', 'A submission is required.');
        }
        $submission->forceFill(['manager_decision' => $decision, 'decided_by' => $manager->getAuthIdentifier(), 'decided_at' => now(), 'decision_reason' => $reason])->save();
    }

    private function denominationTotal(array $rows): ?string
    {
        if ($rows === []) {
            return null;
        }
        $total = '0.0000';
        foreach ($rows as $row) {
            $denomination = Money::normalize((string) ($row['denomination'] ?? ''));
            $quantity = filter_var($row['quantity'] ?? null, FILTER_VALIDATE_INT, ['options' => ['min_range' => 0]]);
            if ($quantity === false) {
                throw new ShiftException('shift_counted_cash_invalid', 'Denomination quantity must be a non-negative integer.');
            }
            $total = Money::add($total, Money::multiply($denomination, $quantity));
        }

        return $total;
    }

    private function requireTransactionLocation(): mixed
    {
        if ($this->locations->isGlobal()) {
            throw ShiftException::conflict('shift_global_mode_not_allowed', 'Select a concrete branch for shift operations.');
        }
        $location = $this->locations->current();
        if (! $location) {
            throw ShiftException::conflict('shift_location_required', 'An active assigned location is required.');
        }
        if (! $location->location_status) {
            throw ShiftException::forbidden('shift_location_forbidden', 'Inactive locations cannot host shifts.');
        }

        return $location;
    }

    private function context(CashierShift $shift, int $actorId): array
    {
        return ['shift_id' => $shift->getKey(), 'location_id' => $shift->location_id, 'staff_id' => $shift->staff_id, 'actor_id' => $actorId, 'status' => $shift->status->value];
    }
}
