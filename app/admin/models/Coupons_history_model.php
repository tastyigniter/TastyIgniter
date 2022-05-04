<?php

namespace Admin\Models;

use Igniter\Flame\Database\Model;

/**
 * Coupons History Model Class
 *
 * @deprecated remove before v4. Added for backward compatibility, see Igniter\Coupons\Models\Coupons_history_model
 */
class Coupons_history_model extends Model
{
    /**
     * @var string The database table name
     */
    protected $table = 'coupons_history';

    /**
     * @var string The database table primary key
     */
    protected $primaryKey = 'coupon_history_id';

    protected $guarded = [];

    protected $appends = ['customer_name'];

    protected $casts = [
        'coupon_history_id' => 'integer',
        'coupon_id' => 'integer',
        'order_id' => 'integer',
        'customer_id' => 'integer',
        'min_total' => 'float',
        'amount' => 'float',
        'status' => 'boolean',
    ];

    public $relation = [
        'belongsTo' => [
            'customer' => 'Admin\Models\Customers_model',
            'order' => 'Admin\Models\Orders_model',
            'coupon' => 'Admin\Models\Coupons_model',
        ],
    ];

    public $timestamps = true;

    public function getCustomerNameAttribute($value)
    {
        return ($this->customer && $this->customer->exists) ? $this->customer->full_name : $value;
    }

    public function scopeIsEnabled($query)
    {
        return $query->where('status', '1');
    }

    public function touchStatus()
    {
        $this->status = ($this->status < 1) ? 1 : 0;

        return $this->save();
    }

    /**
     * @param \Admin\Models\Orders_model $order
     * @param \Igniter\Flame\Cart\CartCondition $couponCondition
     * @param \Admin\Models\Orders_model $order
     * @param \Admin\Models\Customers_model $customer
     * @return \Admin\Models\Coupons_history_model|bool
     */
    public static function createHistory($couponCondition, $order, $customer)
    {
        if (!$coupon = $couponCondition->getModel())
            return false;

        $model = new static;
        $model->order_id = $order->getKey();
        $model->customer_id = $customer ? $customer->getKey() : 0;
        $model->coupon_id = $coupon->coupon_id;
        $model->code = $coupon->code;
        $model->amount = $couponCondition->getValue();
        $model->min_total = $coupon->min_total;

        if ($model->fireSystemEvent('couponHistory.beforeAddHistory', [$couponCondition, $customer, $coupon], true) === false)
            return false;

        $model->save();

        return $model;
    }
}
