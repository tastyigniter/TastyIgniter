<?php namespace Admin\Models;

use Igniter\Flame\ActivityLog\Traits\LogsActivity;
use Model;

/**
 * Coupons Model Class
 *
 * @package Admin
 */
class Coupons_model extends Model
{
    use LogsActivity;

    const CREATED_AT = 'date_added';

    /**
     * @var string The database table name
     */
    protected $table = 'coupons';

    /**
     * @var string The database table primary key
     */
    protected $primaryKey = 'coupon_id';

    public $timestamps = TRUE;

    protected $timeFormat = 'H:i';

    public $casts = [
        'period_start_date'   => 'date',
        'period_end_date'     => 'date',
        'fixed_date'          => 'date',
        'fixed_from_time'     => 'time',
        'fixed_to_time'       => 'time',
        'recurring_from_time' => 'time',
        'recurring_to_time'   => 'time',
    ];

    public $relation = [
        'hasMany' => [
            'history' => 'Admin\Models\Coupons_history_model',
        ],
    ];

    public function getRecurringEveryOptions()
    {
        return ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
    }

    //
    // Accessors & Mutators
    //

    public function getRecurringEveryAttribute($value)
    {
        return (empty($value)) ? [] : explode(', ', $value);
    }

    public function setRecurringEveryAttribute($value)
    {
        return (empty($value)) ? [] : implode(', ', $value);
    }

    public function getTypeNameAttribute($value)
    {
        return ($this->type == 'P') ? lang('text_percentage') : lang('text_fixed_amount');
    }

    public function getFormattedDiscountAttribute($value)
    {
        return ($this->type == 'P') ? round($this->discount).'%' : number_format($this->discount, 2);
    }

    //
    // Scopes
    //

    /**
     * Filter database records
     *
     * @param $query
     * @param array $filter an associative array of field/value pairs
     *
     * @return $this
     */
    public function scopeFilter($query, $filter = [])
    {
        if (isset($filter['filter_search']) AND is_string($filter['filter_search'])) {
            $query->search($filter['filter_search'], ['name', 'code']);
        }

        if (isset($filter['filter_type']) AND is_string($filter['filter_type'])) {
            $query->where('type', $filter['filter_type']);
        }

        if (isset($filter['filter_status']) AND is_numeric($filter['filter_status'])) {
            $query->where('status', $filter['filter_status']);
        }

        return $query;
    }

    //
    // Helpers
    //

    /**
     * Return all coupons
     *
     * @return array
     */
    public function getCoupons()
    {
        return self::get();
    }

    /**
     * Find a single coupon by coupon_id
     *
     * @param int $coupon_id
     *
     * @return array
     */
    public function getCoupon($coupon_id)
    {
        return $this->find($coupon_id);
    }

    /**
     * Find a single coupon by coupon code
     *
     * @param string $code
     *
     * @return array
     */
    public function getCouponByCode($code)
    {
        return $this->first(['code' => $code]);
    }

    /**
     * Return all coupon history by coupon_id
     *
     * @return array
     */
    public function getCouponHistories()
    {
        $couponHistoryTable = DB::getTablePrefix().'coupons_history';

        $query = $this->newQuery()->history()->join('orders', 'orders.order_id', '=', 'coupons_history.order_id', 'left');
        $query->join('customers', 'customers.customer_id', '=', 'coupons_history.customer_id', 'left');
        $query->selectRaw("*, COUNT({$couponHistoryTable}.customer_id) as total_redemption, SUM(amount) as total_amount, ".
            "MAX({$couponHistoryTable}.date_used) as date_last_used");
        $query->groupBy('customers.customer_id');
        $query->where('coupon_id', $this->getKey());

        return $query->orderBy('date_used', 'DESC')->get();
    }

    /**
     * Redeem coupon by order_id
     *
     * @param int $order_id
     *
     * @return bool TRUE on success, or FALSE on failure
     */
    public function redeemCoupon($order_id)
    {
        $query = $this->newQuery()->history()->where('status', '!=', '1')->where('order_id', $order_id);
        if ($couponModel = $query->first()) {
            return $couponModel->touchStatus();
        }
    }

    /**
     * Create a new or update existing coupon
     *
     * @param int $coupon_id
     * @param array $save
     *
     * @return bool|int The $coupon_id of the affected row, or FALSE on failure
     */
    public function saveCoupon($coupon_id, $save = [])
    {
        if (empty($save)) return FALSE;

        $couponModel = $this->findOrNew($coupon_id);

        $saved = $couponModel->fill($save)->save();

        return $saved ? $couponModel->getKey() : $saved;
    }

    /**
     * Delete a single or multiple coupon by coupon_id
     *
     * @param string|array $coupon_id
     *
     * @return int The number of deleted rows
     */
    public function deleteCoupon($coupon_id)
    {
        if (is_numeric($coupon_id)) $coupon_id = [$coupon_id];

        if (!empty($coupon_id) AND ctype_digit(implode('', $coupon_id))) {
            return $this->whereIn('coupon_id', $coupon_id)->delete();
        }
    }
}