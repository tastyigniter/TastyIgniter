<?php

namespace Admin\Models;

use Carbon\Carbon;
use Igniter\Flame\Auth\Models\User;
use Igniter\Flame\Database\Model;
use Igniter\Flame\Location\Models\AbstractLocation;

/**
 * Coupons Model Class
 * @deprecated remove before v4. Added for backward compatibility, see Igniter\Coupons\Models\Coupons_model
 */
class Coupons_model extends Model
{
    use \Admin\Traits\Locationable;

    const LOCATIONABLE_RELATION = 'locations';

    /**
     * @var string The database table name
     */
    protected $table = 'coupons';

    /**
     * @var string The database table primary key
     */
    protected $primaryKey = 'coupon_id';

    protected $timeFormat = 'H:i';

    public $timestamps = true;

    protected $casts = [
        'discount' => 'float',
        'min_total' => 'float',
        'redemptions' => 'integer',
        'customer_redemptions' => 'integer',
        'status' => 'boolean',
        'period_start_date' => 'date',
        'period_end_date' => 'date',
        'fixed_date' => 'date',
        'fixed_from_time' => 'time',
        'fixed_to_time' => 'time',
        'recurring_from_time' => 'time',
        'recurring_to_time' => 'time',
        'order_restriction' => 'integer',
    ];

    public $relation = [
        'hasMany' => [
            'history' => 'Admin\Models\Coupons_history_model',
        ],
        'morphToMany' => [
            'locations' => ['Admin\Models\Locations_model', 'name' => 'locationable'],
        ],
    ];

    public function getRecurringEveryOptions()
    {
        return ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
    }

    //
    // Accessors & Mutators
    //

    public function getRecurringEveryAttribute($value)
    {
        return empty($value) ? [0, 1, 2, 3, 4, 5, 6] : explode(', ', $value);
    }

    public function setRecurringEveryAttribute($value)
    {
        $this->attributes['recurring_every'] = empty($value)
            ? null : implode(', ', $value);
    }

    public function getTypeNameAttribute($value)
    {
        return ($this->type == 'P') ? lang('admin::lang.menus.text_percentage') : lang('admin::lang.menus.text_fixed_amount');
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

    public function isFixed()
    {
        return $this->type == 'F';
    }

    public function discountWithOperand()
    {
        return ($this->isFixed() ? '-' : '-%').$this->discount;
    }

    public function minimumOrderTotal()
    {
        return $this->min_total ?: 0;
    }

    public function isExpired()
    {
        $now = Carbon::now();

        switch ($this->validity) {
            case 'forever':
                return false;
            case 'fixed':
                $start = $this->fixed_date->copy()->setTimeFromTimeString($this->fixed_from_time);
                $end = $this->fixed_date->copy()->setTimeFromTimeString($this->fixed_to_time);

                return !$now->between($start, $end);
            case 'period':
                return !$now->between($this->period_start_date, $this->period_end_date);
            case 'recurring':
                if (!in_array($now->format('w'), $this->recurring_every))
                    return true;

                $start = $now->copy()->setTimeFromTimeString($this->recurring_from_time);
                $end = $now->copy()->setTimeFromTimeString($this->recurring_to_time);

                return !$now->between($start, $end);
        }

        return false;
    }

    public function hasRestriction($orderType)
    {
        if (empty($this->order_restriction))
            return false;

        $orderTypes = [AbstractLocation::DELIVERY => 1, AbstractLocation::COLLECTION => 2];

        return array_get($orderTypes, $orderType, $orderType) != $this->order_restriction;
    }

    public function hasLocationRestriction($locationId)
    {
        if (!$this->locations || $this->locations->isEmpty())
            return false;

        $locationKeyColumn = $this->locations()->getModel()->qualifyColumn('location_id');

        return !$this->locations()->where($locationKeyColumn, $locationId)->exists();
    }

    public function hasReachedMaxRedemption()
    {
        return $this->redemptions && $this->redemptions <= $this->countRedemptions();
    }

    public function customerHasMaxRedemption(User $user)
    {
        return $this->customer_redemptions && $this->customer_redemptions <= $this->countCustomerRedemptions($user->getKey());
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
