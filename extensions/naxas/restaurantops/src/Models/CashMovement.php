<?php

declare(strict_types=1);

namespace Naxas\RestaurantOps\Models;

use Igniter\Flame\Database\Model;
use Naxas\RestaurantOps\Shifts\Exceptions\ShiftException;

final class CashMovement extends Model
{
    protected $table = 'naxas_restaurant_ops_cash_movements';

    protected $guarded = ['id'];

    protected $casts = ['shift_id' => 'integer', 'location_id' => 'integer', 'amount' => 'decimal:4', 'occurred_at' => 'datetime', 'reversed_at' => 'datetime'];

    public $relation = ['belongsTo' => ['shift' => [CashierShift::class, 'foreignKey' => 'shift_id']]];

    protected static function booted(): void
    {
        self::updating(function (self $movement): void {
            $allowed = ['reversed_at', 'reversed_by', 'reversal_reason', 'updated_at'];
            if (array_diff(array_keys($movement->getDirty()), $allowed)) {
                throw ShiftException::conflict('shift_cash_movement_forbidden', 'Cash movements may only be corrected by reversal.');
            }
        });
        self::deleting(fn (): never => throw ShiftException::conflict('shift_cash_movement_forbidden', 'Cash movements cannot be deleted.'));
    }
}
