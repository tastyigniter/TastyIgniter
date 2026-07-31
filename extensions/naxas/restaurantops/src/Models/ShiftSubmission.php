<?php

declare(strict_types=1);

namespace Naxas\RestaurantOps\Models;

use Igniter\Flame\Database\Model;
use Naxas\RestaurantOps\Shifts\Exceptions\ShiftException;

final class ShiftSubmission extends Model
{
    protected $table = 'naxas_restaurant_ops_shift_submissions';

    protected $guarded = ['id'];

    protected $casts = [
        'revision' => 'integer', 'opening_cash' => 'decimal:4', 'expected_cash' => 'decimal:4',
        'counted_cash' => 'decimal:4', 'variance' => 'decimal:4', 'payment_summary' => 'array',
        'cash_movement_summary' => 'array', 'order_summary' => 'array', 'open_order_warnings' => 'array',
        'submitted_at' => 'datetime', 'decided_at' => 'datetime',
    ];

    public $relation = [
        'belongsTo' => ['shift' => [CashierShift::class, 'foreignKey' => 'shift_id']],
        'hasMany' => ['denominations' => [ShiftDenomination::class, 'foreignKey' => 'shift_submission_id']],
    ];

    protected static function booted(): void
    {
        self::updating(function (self $submission): void {
            if (array_diff(array_keys($submission->getDirty()), ['manager_decision', 'decided_by', 'decided_at', 'decision_reason', 'updated_at'])) {
                throw ShiftException::conflict('shift_submission_immutable', 'Submission snapshots are immutable.');
            }
            if ($submission->getOriginal('manager_decision')) {
                throw ShiftException::conflict('shift_submission_immutable', 'A manager decision is immutable.');
            }
        });
        self::deleting(fn (): never => throw ShiftException::conflict('shift_submission_immutable', 'Submission snapshots cannot be deleted.'));
    }
}
