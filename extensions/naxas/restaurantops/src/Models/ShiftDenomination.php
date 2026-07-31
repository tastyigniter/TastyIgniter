<?php

declare(strict_types=1);

namespace Naxas\RestaurantOps\Models;

use Igniter\Flame\Database\Model;
use Naxas\RestaurantOps\Shifts\Exceptions\ShiftException;

final class ShiftDenomination extends Model
{
    protected $table = 'naxas_restaurant_ops_shift_denominations';

    protected $guarded = ['id'];

    protected $casts = ['denomination' => 'decimal:4', 'total' => 'decimal:4', 'quantity' => 'integer'];

    protected static function booted(): void
    {
        self::updating(fn (): never => throw ShiftException::conflict('shift_submission_immutable', 'Denomination snapshots are immutable.'));
        self::deleting(fn (): never => throw ShiftException::conflict('shift_submission_immutable', 'Denomination snapshots cannot be deleted.'));
    }
}
