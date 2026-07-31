<?php

declare(strict_types=1);

namespace Naxas\RestaurantOps\Models;

use Igniter\Flame\Database\Model;
use Naxas\RestaurantOps\Shifts\Exceptions\ShiftException;
use Naxas\RestaurantOps\Shifts\ShiftStatus;

final class CashierShift extends Model
{
    protected $table = 'naxas_restaurant_ops_cashier_shifts';

    protected $guarded = ['id'];

    protected $casts = [
        'location_id' => 'integer', 'staff_id' => 'integer', 'active_staff_id' => 'integer',
        'opening_cash' => 'decimal:4', 'expected_cash' => 'decimal:4', 'counted_cash' => 'decimal:4', 'variance' => 'decimal:4',
        'submission_revision' => 'integer', 'version' => 'integer',
        'opened_at' => 'datetime', 'closing_requested_at' => 'datetime', 'submitted_at' => 'datetime',
        'approved_at' => 'datetime', 'rejected_at' => 'datetime', 'force_closed_at' => 'datetime', 'cancelled_at' => 'datetime',
        'status' => ShiftStatus::class,
    ];

    public $relation = [
        'hasMany' => [
            'movements' => [CashMovement::class, 'foreignKey' => 'shift_id'],
            'submissions' => [ShiftSubmission::class, 'foreignKey' => 'shift_id'],
        ],
    ];

    protected static function booted(): void
    {
        self::updating(function (self $shift): void {
            if (($shift->getOriginal('status') instanceof ShiftStatus ? $shift->getOriginal('status') : ShiftStatus::tryFrom((string) $shift->getOriginal('status')))?->isTerminal()) {
                throw ShiftException::conflict('shift_approved_immutable', 'Terminal shifts are immutable.');
            }

            foreach (['location_id', 'staff_id', 'opened_at', 'opening_cash'] as $field) {
                if ($shift->isDirty($field)) {
                    throw ShiftException::conflict('shift_immutable_identity', "Shift {$field} is immutable.");
                }
            }
        });
        self::deleting(fn (): never => throw ShiftException::conflict('shift_approved_immutable', 'Shifts cannot be deleted.'));
    }
}
