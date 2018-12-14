<?php namespace Admin\Models;

use Carbon\Carbon;
use Igniter\Flame\ActivityLog\Traits\LogsActivity;
use Igniter\Flame\Auth\Models\User;
use Model;

/**
 * Coupons Model Class
 *
 * @package Admin
 */
class Coupons_model extends Model
{
    use LogsActivity;

    const UPDATED_AT = null;

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
        'period_start_date' => 'date',
        'period_end_date' => 'date',
        'fixed_date' => 'date',
        'fixed_from_time' => 'time',
        'fixed_to_time' => 'time',
        'recurring_from_time' => 'time',
        'recurring_to_time' => 'time',
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
        return (empty($value)) ? [0, 1, 2, 3, 4, 5, 6] : explode(', ', $value);
    }

    public function setRecurringEveryAttribute($value)
    {
        return (empty($value)) ? [] : implode(', ', $value);
    }

    public function getTypeNameAttribute($value)
    {
        return ($this->type == 'P') ? lang('admin::lang.coupons.text_percentage') : lang('admin::lang.coupons.text_fixed_amount');
    }

    public function getFormattedDiscountAttribute($value)
    {
        return ($this->type == 'P') ? round($this->discount).'%' : number_format($this->discount, 2);
    }

    //
    // Scopes
    //

    public function scopeIsEnabled($query)
    {
        return $query->where('status', '1');
    }

    //
    // Helpers
    //

    public function getMessageForEvent($eventName)
    {
        return parse_values(['event' => $eventName], lang('admin::lang.coupons.activity_event_log'));
    }

    public function isFixed()
    {
        return $this->type == 'F';
    }

    public function discountWithOperand()
    {
        return ($this->isFixed() ? "-" : "-%").$this->discount;
    }

    public function minimumOrderTotal()
    {
        return $this->min_total;
    }

    public function isExpired()
    {
        $now = Carbon::now();

        switch ($this->validity) {
            case 'forever':
                return FALSE;
            case 'fixed':
                return $this->fixed_date->eq($now) AND !$now->between($this->fixed_from_time, $this->fixed_to_time);
            case 'period':
                return $now->between($this->period_start_date, $this->period_end_date) ? FALSE : TRUE;
            case 'recurring':
                if (!in_array($now->format('l'), $this->recurring_every))
                    return TRUE;

                return $now->between($this->recurring_from_time, $this->recurring_to_time) ? FALSE : TRUE;
        }

        return FALSE;
    }

    public function hasRestriction($orderType)
    {
        if (is_null($this->order_restriction))
            FALSE;

        return $orderType != $this->order_restriction;
    }

    public function hasReachedMaxRedemption()
    {
        return !$this->redemptions OR $this->redemptions <= $this->countRedemptions();
    }

    public function customerHasMaxRedemption(User $user)
    {
        if (!$this->customer_redemptions)
            return FALSE;

        $customerRedemptionCount = $this->countCustomerRedemptions($user->getKey());

        return $this->customer_redemptions <= $customerRedemptionCount;
    }

    public function countRedemptions()
    {
        return $this->history()->isEnabled()->count();
    }

    public function countCustomerRedemptions($id)
    {
        return $this->history()->isEnabled()
                    ->where('customer_id', $id)->count();
    }
}