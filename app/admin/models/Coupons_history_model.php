<?php namespace Admin\Models;

use Model;

/**
 * Coupons History Model Class
 *
 * @package Admin
 */
class Coupons_history_model extends Model
{
    const CREATED_AT = 'date_used';

    const UPDATED_AT = null;

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

    public $casts = [
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

    public $timestamps = TRUE;

    public function getCustomerNameAttribute($value)
    {
        return ($this->customer AND $this->customer->exists) ? $this->customer->full_name : $value;
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
}