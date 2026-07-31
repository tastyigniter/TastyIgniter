<?php

declare(strict_types=1);

namespace Naxas\RestaurantOps\Models;

use Igniter\Flame\Database\Model;

final class PosApprovalRequest extends Model
{
    protected $table = 'naxas_restaurant_ops_pos_approval_requests';

    public $guarded = [];

    protected $casts = ['requested_at' => 'datetime', 'decided_at' => 'datetime'];
}
