<?php

declare(strict_types=1);

namespace Igniter\Coupons\Models;

use Igniter\Cart\Models\Order;
use Igniter\Flame\Database\Factories\HasFactory;
use Igniter\Flame\Database\Model;
use Igniter\System\Models\Concerns\Switchable;
use Igniter\User\Models\Concerns\HasCustomer;
use Igniter\User\Models\Customer;
use Illuminate\Support\Carbon;

/**
 * Coupons History Model Class
 *
 * @property int $coupon_history_id
 * @property int $coupon_id
 * @property int|null $order_id
 * @property int|null $customer_id
 * @property string $code
 * @property float|null $min_total
 * @property float|null $amount
 * @property Carbon $created_at
 * @property bool $status
 * @property Carbon $updated_at
 * @property-read mixed $customer_name
 * @property  Order|null $order
 * @property  Customer|null $customer
 * @mixin Model
 */
class CouponHistory extends Model
{
    use HasCustomer;
    use HasFactory;
    use Switchable;

    /**
     * @var string The database table name
     */
    protected $table = 'igniter_coupons_history';

    /**
     * @var string The database table primary key
     */
    protected $primaryKey = 'coupon_history_id';

    public $timestamps = true;

    protected $guarded = [];

    protected $appends = ['customer_name', 'order_total', 'date_used'];

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
            'customer' => Customer::class,
            'order' => Order::class,
            'coupon' => Coupon::class,
        ],
    ];

    protected array $queryModifierFilters = [
        'redeemed' => ['applyRedeemed', 'default' => true],
        'customer' => 'applyCustomer',
        'order_id' => 'whereOrderId',
    ];

    protected array $queryModifierSorts = [
        'created_at desc' => true, 'created_at asc',
    ];

    public static function redeem($orderId): bool
    {
        /** @var null|CouponHistory $couponHistory */
        $couponHistory = static::query()->orderBy('created_at', 'desc')->firstWhere('order_id', $orderId);
        if (is_null($couponHistory)) {
            return false;
        }

        $couponHistory->update([
            'status' => 1,
            'created_at' => now(),
        ]);

        static::query()
            ->where('order_id', $orderId)
            ->where('coupon_history_id', '<>', $couponHistory->coupon_history_id)
            ->delete();

        $couponHistory->fireSystemEvent('admin.order.couponRedeemed');

        return true;
    }

    public function getCustomerNameAttribute($value): ?string
    {
        return ($this->customer && $this->customer->exists) ? $this->customer->full_name : $value;
    }

    public function getOrderTotalAttribute($value): ?float
    {
        return $this->order?->order_total;
    }

    public function getDateUsedAttribute($value): string
    {
        return day_elapsed($this->created_at);
    }

    public function scopeApplyRedeemed($query)
    {
        return $query->where('status', '>=', 1);
    }

    public function touchStatus(): bool
    {
        $this->status = $this->status < 1;

        return $this->save();
    }

    /**
     * @param object $couponTotal
     * @param Order $order
     */
    public static function createHistory($couponTotal, $order): ?self
    {
        if ($couponTotal->code === 'coupon' && str_contains((string)$couponTotal->title, '[')) {
            $couponTotal->code = str_after(str_before($couponTotal->title, ']'), '[');
        }

        /** @var null|Coupon $coupon */
        $coupon = Coupon::firstWhere('code', $couponTotal->code);
        if (is_null($coupon)) {
            return null;
        }

        $model = new static;
        $model->order_id = $order->getKey();
        $model->customer_id = $order->customer ? $order->customer->getKey() : null;
        $model->coupon_id = $coupon->coupon_id;
        $model->code = $coupon->code;
        $model->amount = $couponTotal->value;
        $model->min_total = $coupon->min_total;

        if ($model->fireSystemEvent('couponHistory.beforeAddHistory', [$couponTotal, $order->customer, $coupon]) === false) {
            return null;
        }

        $model->save();

        return $model;
    }
}
