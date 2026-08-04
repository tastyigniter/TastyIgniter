<?php

declare(strict_types=1);

namespace Naxas\RestaurantOps\Models;

use Igniter\Flame\Database\Model;

final class PosPayment extends Model
{
    protected $table = 'naxas_restaurant_ops_pos_payments';

    protected $guarded = ['id'];

    protected $casts = ['paid_at' => 'datetime', 'failed_at' => 'datetime', 'reversed_at' => 'datetime', 'version' => 'integer'];

    public $relation = ['belongsTo' => ['order' => [PosOrder::class, 'foreignKey' => 'pos_order_id'], 'shift' => [CashierShift::class, 'foreignKey' => 'cashier_shift_id']], 'hasMany' => ['tenders' => [PosPaymentTender::class, 'foreignKey' => 'pos_payment_id'], 'events' => [PosPaymentEvent::class, 'foreignKey' => 'pos_payment_id'], 'reversals' => [PosPaymentReversal::class, 'foreignKey' => 'pos_payment_id']], 'hasOne' => ['receipt' => [PosReceipt::class, 'foreignKey' => 'pos_payment_id']]];
}
