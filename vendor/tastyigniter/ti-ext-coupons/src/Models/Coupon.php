<?php

declare(strict_types=1);

namespace Igniter\Coupons\Models;

use Carbon\Carbon;
use Igniter\Cart\CartContent;
use Igniter\Cart\Models\Category;
use Igniter\Cart\Models\Menu;
use Igniter\Flame\Database\Builder;
use Igniter\Flame\Database\Factories\HasFactory;
use Igniter\Flame\Database\Model;
use Igniter\Flame\Exception\ApplicationException;
use Igniter\Local\Models\Concerns\Locationable;
use Igniter\Local\Models\Location;
use Igniter\System\Models\Concerns\Switchable;
use Igniter\User\Models\Customer;
use Igniter\User\Models\CustomerGroup;

/**
 * Coupons Model Class
 *
 * @property int $coupon_id
 * @property string $name
 * @property string $code
 * @property string $type
 * @property float|null $discount
 * @property float|null $min_total
 * @property int $redemptions
 * @property int $customer_redemptions
 * @property string|null $description
 * @property bool|null $status
 * @property \Illuminate\Support\Carbon $created_at
 * @property string|null $validity
 * @property \Illuminate\Support\Carbon|null $fixed_date
 * @property mixed|null $fixed_from_time
 * @property mixed|null $fixed_to_time
 * @property \Illuminate\Support\Carbon|null $period_start_date
 * @property \Illuminate\Support\Carbon|null $period_end_date
 * @property array|string|null $recurring_every
 * @property mixed|null $recurring_from_time
 * @property mixed|null $recurring_to_time
 * @property array|null $order_restriction
 * @property string $apply_coupon_on
 * @property bool $auto_apply
 * @property \Illuminate\Support\Carbon $updated_at
 * @property-read mixed $formatted_discount
 * @property-read mixed $type_name
 * @method static Builder<static>|Coupon isAutoApplicable()
 * @method static Builder<static>|Coupon whereHasOrDoesntHaveLocation(null|int $locationId = null)
 * @mixin Model
 * @mixin Builder
 */
class Coupon extends Model
{
    use HasFactory;
    use Locationable;
    use Switchable;

    public const string LOCATIONABLE_RELATION = 'locations';

    /**
     * @var string The database table name
     */
    protected $table = 'igniter_coupons';

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
        'order_restriction' => 'array',
        'auto_apply' => 'boolean',
    ];

    public $relation = [
        'belongsToMany' => [
            'categories' => [Category::class, 'table' => 'igniter_coupon_categories'],
            'menus' => [Menu::class, 'table' => 'igniter_coupon_menus'],
            'customers' => [Customer::class, 'table' => 'igniter_coupon_customers'],
            'customer_groups' => [CustomerGroup::class, 'table' => 'igniter_coupon_customer_groups'],
        ],
        'hasMany' => [
            'history' => CouponHistory::class,
        ],
        'morphToMany' => [
            'locations' => [Location::class, 'name' => 'locationable'],
        ],
    ];

    protected array $queryModifierFilters = [
        'enabled' => ['applySwitchable', 'default' => true],
    ];

    protected array $queryModifierSorts = [
        'name desc', 'name asc',
        'coupon_id desc', 'coupon_id asc',
        'code desc', 'code asc',
    ];

    public function getRecurringEveryOptions(): array
    {
        return ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
    }

    public static function getDropdownOptions()
    {
        return static::whereIsEnabled()->dropdown('name');
    }

    //
    // Accessors & Mutators
    //

    public function getRecurringEveryAttribute($value)
    {
        return empty($value) ? [0, 1, 2, 3, 4, 5, 6] : explode(', ', (string)$value);
    }

    public function setRecurringEveryAttribute($value): void
    {
        $this->attributes['recurring_every'] = empty($value)
            ? null : implode(', ', $value);
    }

    public function getTypeNameAttribute($value): string
    {
        return ($this->type == 'P') ? lang('igniter.coupons::default.text_percentage') : lang('igniter.coupons::default.text_fixed_amount');
    }

    public function getFormattedDiscountAttribute($value): string
    {
        return ($this->type == 'P') ? round($this->discount).'%' : number_format($this->discount, 2);
    }

    //
    // Events
    //
    /**
     * Create new or update existing menu categories
     *
     * @param array $categoryIds if empty all existing records will be deleted
     */
    public function addMenuCategories(array $categoryIds = []): void
    {
        $this->categories()->sync($categoryIds);
    }

    /**
     * Create new or update existing menus
     *
     * @param array $menuIds if empty all existing records will be deleted
     */
    public function addMenus(array $menuIds = []): void
    {
        $this->menus()->sync($menuIds);
    }

    //
    // Helpers
    //

    public function isFixed(): bool
    {
        return $this->type == 'F';
    }

    public function discountWithOperand(): string
    {
        return ($this->isFixed() ? '-' : '-%').$this->discount;
    }

    public function minimumOrderTotal()
    {
        return $this->min_total ?: 0;
    }

    /**
     * Check if a coupon is expired
     *
     * @param Carbon $orderDateTime orderDateTime
     *
     * @return bool
     */
    public function isExpired($orderDateTime = null)
    {
        if (is_null($orderDateTime)) {
            $orderDateTime = Carbon::now();
        }

        switch ($this->validity) {
            case 'forever':
                return false;
            case 'fixed':
                $start = $this->fixed_date->copy()->setTimeFromTimeString($this->fixed_from_time);
                $end = $this->fixed_date->copy()->setTimeFromTimeString($this->fixed_to_time);

                if ($start->gt($end)) {
                    $end->addDay();
                }

                return !$orderDateTime->between($start, $end);
            case 'period':
                return !$orderDateTime->between($this->period_start_date, $this->period_end_date);
            case 'recurring':
                if (!in_array($orderDateTime->format('w'), $this->recurring_every)) {
                    return true;
                }

                $start = $orderDateTime->copy()->setTimeFromTimeString($this->recurring_from_time);
                $end = $orderDateTime->copy()->setTimeFromTimeString($this->recurring_to_time);

                if ($start->gt($end)) {
                    $end->addDay();
                }

                return !$orderDateTime->between($start, $end);
        }

        if ($result = $this->fireSystemEvent('igniter.coupon.isExpired', [$orderDateTime])) {
            return $result;
        }

        return false;
    }

    public function hasRestriction($orderType)
    {
        if (empty($this->order_restriction)) {
            return false;
        }

        return !in_array($orderType, $this->order_restriction);
    }

    public function hasLocationRestriction($locationId)
    {
        if (!$this->locations || $this->locations->isEmpty()) {
            return false;
        }

        $locationKeyColumn = $this->locations()->getModel()->qualifyColumn('location_id');

        return !$this->locations()->where($locationKeyColumn, $locationId)->exists();
    }

    public function hasReachedMaxRedemption(): bool
    {
        return $this->redemptions && $this->redemptions <= $this->countRedemptions();
    }

    public function customerHasMaxRedemption(Customer $customer): bool
    {
        return $this->customer_redemptions && $this->customer_redemptions <= $this->countCustomerRedemptions($customer->getKey());
    }

    public function customerCanRedeem(?Customer $customer = null)
    {
        if (!$this->customers || $this->customers->isEmpty()) {
            return true;
        }

        return $customer && $this->customers->contains('customer_id', $customer->getKey());
    }

    public function customerGroupCanRedeem(?CustomerGroup $group = null)
    {
        if (!$this->customer_groups || $this->customer_groups->isEmpty()) {
            return true;
        }

        return $group && $this->customer_groups->contains('customer_group_id', $group->getKey());
    }

    public function countRedemptions()
    {
        return $this->history()->whereIsEnabled()->count();
    }

    public function countCustomerRedemptions($id)
    {
        return $this->history()->isEnabled()
            ->where('customer_id', $id)->count();
    }

    public function appliesOnWholeCart(): bool
    {
        return $this->apply_coupon_on == 'whole_cart';
    }

    public function appliesOnMenuItems(): bool
    {
        return $this->apply_coupon_on == 'menu_items';
    }

    public function appliesOnDelivery(): bool
    {
        return $this->apply_coupon_on == 'delivery_fee';
    }

    public function canRedeemOnMenuItemQuantity(int $quantity): bool
    {
        if (empty($this->min_menu_quantity)) {
            return true;
        }

        return $quantity >= $this->min_menu_quantity;
    }

    public static function getByCode($code)
    {
        return self::whereIsEnabled()->whereCode($code)->first();
    }

    public static function getByCodeAndLocation($code, $locationId)
    {
        return self::whereIsEnabled()->whereCodeAndLocation($code, $locationId)->first();
    }

    public function isValid(
        string $orderType,
        Carbon $orderDateTime,
        CartContent $content,
        ?Customer $user,
        ?int $locationId,
    ): bool {
        return rescue(function() use (
            $orderType,
            $orderDateTime,
            $content,
            $user,
            $locationId,
        ): true {
            $this->validateCoupon($orderType, $orderDateTime, $content, $user, $locationId);

            return true;
        }, false);
    }

    public function validateCoupon(
        string $orderType,
        Carbon $orderDateTime,
        CartContent $content,
        ?Customer $user,
        ?int $locationId,
    ): void {
        if ($this->isExpired($orderDateTime)) {
            throw new ApplicationException(lang('igniter.cart::default.alert_coupon_expired'));
        }

        if ($this->hasRestriction($orderType)) {
            throw new ApplicationException(sprintf(
                lang('igniter.cart::default.alert_coupon_order_restriction'), $orderType,
            ));
        }

        if ($this->hasLocationRestriction($locationId)) {
            throw new ApplicationException(lang('igniter.cart::default.alert_coupon_location_restricted'));
        }

        if ($content->subtotalWithoutConditions() < $this->minimumOrderTotal()) {
            throw new ApplicationException(sprintf(
                lang('igniter.cart::default.alert_coupon_not_applied'),
                currency_format($this->minimumOrderTotal()),
            ));
        }

        if ($this->hasReachedMaxRedemption()) {
            throw new ApplicationException(lang('igniter.cart::default.alert_coupon_maximum_reached'));
        }

        if (($this->customers?->isNotEmpty() || $this->customer_groups?->isNotEmpty()) && !$user) {
            throw new ApplicationException(lang('igniter.coupons::default.alert_coupon_login_required'));
        }

        if ($user && $this->customerHasMaxRedemption($user)) {
            throw new ApplicationException(lang('igniter.cart::default.alert_coupon_maximum_reached'));
        }

        throw_unless($this->customerCanRedeem($user),
            new ApplicationException(lang('igniter.coupons::default.alert_customer_cannot_redeem')));

        throw_unless($this->customerGroupCanRedeem($user?->group),
            new ApplicationException(lang('igniter.coupons::default.alert_customer_group_cannot_redeem')));

    }
}
