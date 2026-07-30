<?php

declare(strict_types=1);

namespace Igniter\Cart\Models;

use Carbon\Carbon;
use Igniter\Admin\Models\Concerns\GeneratesHash;
use Igniter\Admin\Models\Concerns\LogsStatusHistory;
use Igniter\Admin\Models\Status;
use Igniter\Admin\Models\StatusHistory;
use Igniter\Cart\Events\OrderBeforePaymentProcessedEvent;
use Igniter\Cart\Events\OrderCanceledEvent;
use Igniter\Cart\Events\OrderPaymentProcessedEvent;
use Igniter\Cart\Models\Concerns\HasInvoice;
use Igniter\Cart\Models\Concerns\LocationAction;
use Igniter\Cart\Models\Concerns\ManagesOrderItems;
use Igniter\Flame\Database\Builder;
use Igniter\Flame\Database\Casts\Serialize;
use Igniter\Flame\Database\Factories\HasFactory;
use Igniter\Flame\Database\Model;
use Igniter\Flame\Database\Relations\HasMany;
use Igniter\Local\Models\Concerns\Locationable;
use Igniter\Local\Models\Location;
use Igniter\Main\Classes\MainController;
use Igniter\PayRegister\Models\Payment;
use Igniter\PayRegister\Models\PaymentLog;
use Igniter\System\Models\Concerns\SendsMailTemplate;
use Igniter\User\Models\Address;
use Igniter\User\Models\Concerns\Assignable;
use Igniter\User\Models\Concerns\HasCustomer;
use Igniter\User\Models\Customer;
use Illuminate\Support\Collection;
use Override;

/**
 * Order Model Class
 *
 * @property int $order_id
 * @property int|null $customer_id
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string $telephone
 * @property int $location_id
 * @property int|null $address_id
 * @property mixed $cart
 * @property int $total_items
 * @property string|null $comment
 * @property string $payment
 * @property string $order_type
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property mixed $order_time
 * @property \Illuminate\Support\Carbon $order_date
 * @property float|null $order_total
 * @property int $status_id
 * @property string $ip_address
 * @property string $user_agent
 * @property int|null $assignee_id
 * @property int|null $assignee_group_id
 * @property string|null $invoice_prefix
 * @property \Illuminate\Support\Carbon|null $invoice_date
 * @property string|null $hash
 * @property bool|null $processed
 * @property \Illuminate\Support\Carbon|null $status_updated_at
 * @property \Illuminate\Support\Carbon|null $assignee_updated_at
 * @property bool $order_time_is_asap
 * @property string|null $delivery_comment
 * @property-read mixed $customer_name
 * @property-read mixed $formatted_address
 * @property-read mixed $invoice_no
 * @property-read mixed $invoice_number
 * @property-read mixed $order_datetime
 * @property-read mixed $order_type_name
 * @property-read string|null $status_color
 * @property-read string|null $status_name
 * @property Customer|null $customer
 * @property Location|LocationAction|null $location
 * @property Address|null $address
 * @property Payment|null $payment_method
 * @property \Illuminate\Database\Eloquent\Collection<int, PaymentLog> $payment_logs
 * @property \Illuminate\Database\Eloquent\Collection<int, OrderMenu> $menus
 * @property \Illuminate\Database\Eloquent\Collection<int, OrderMenuOptionValue> $menu_options
 * @property \Illuminate\Database\Eloquent\Collection<int, OrderTotal> $totals
 * @method static HasMany|PaymentLog payment_logs()
 * @method static Builder<static>|Order whereIsEnabled()
 * @method static Builder<static>|Order whereHasAutoAssignGroup()
 * @method static Builder<static>|Order whereHasStatusInHistory(string | int $statusId)
 * @method static Builder<static>|Menu menus()
 * @method static Builder<static>|OrderMenuOptionValue menu_options()
 * @mixin Model
 */
class Order extends Model
{
    use Assignable;
    use GeneratesHash;
    use HasCustomer;
    use HasFactory;
    use HasInvoice;
    use Locationable;
    use LogsStatusHistory;
    use ManagesOrderItems;
    use SendsMailTemplate;

    public const string DELIVERY = 'delivery';

    public const string COLLECTION = 'collection';

    /**
     * @var string The database table name
     */
    protected $table = 'orders';

    /**
     * @var string The database table primary key
     */
    protected $primaryKey = 'order_id';

    public $timestamps = true;

    protected $timeFormat = 'H:i';

    public $guarded = ['ip_address', 'user_agent', 'hash', 'total_items', 'order_total'];

    protected $hidden = ['cart'];

    public $appends = ['customer_name', 'order_type_name', 'order_date_time', 'formatted_address'];

    protected $casts = [
        'customer_id' => 'integer',
        'location_id' => 'integer',
        'address_id' => 'integer',
        'total_items' => 'integer',
        'cart' => Serialize::class,
        'order_date' => 'date',
        'order_time' => 'time',
        'order_total' => 'float',
        'notify' => 'boolean',
        'processed' => 'boolean',
        'order_time_is_asap' => 'boolean',
    ];

    public $relation = [
        'belongsTo' => [
            'customer' => Customer::class,
            'location' => Location::class,
            'address' => Address::class,
            'payment_method' => [Payment::class, 'foreignKey' => 'payment', 'otherKey' => 'code'],
        ],
        'hasMany' => [
            'payment_logs' => PaymentLog::class,
            'menus' => OrderMenu::class,
            'menu_options' => OrderMenuOptionValue::class,
            'totals' => OrderTotal::class,
        ],
    ];

    protected array $queryModifierFilters = [
        'customer' => 'applyCustomer',
        'dateTimeFilter' => 'applyDateTimeFilter',
        'location' => 'whereHasLocation',
        'status' => 'whereStatus',
    ];

    protected array $queryModifierSorts = [
        'order_id asc', 'order_id desc',
        'created_at asc', 'created_at desc',
        'total asc', 'total desc',
        'order_date asc', 'order_date desc',
        'order_time asc', 'order_time desc',
        'order_type asc', 'order_type desc',
    ];

    protected array $queryModifierSearchableFields = ['order_id', 'first_name', 'last_name', 'email', 'telephone'];

    public function listCustomerAddresses()
    {
        return $this->customer->addresses ?? [];
    }

    //
    // Accessors & Mutators
    //

    public function getCustomerNameAttribute($value): string
    {
        return $this->first_name.' '.$this->last_name;
    }

    public function getOrderTypeNameAttribute()
    {
        if (!$this->location) {
            return $this->order_type;
        }

        return $this->location->availableOrderTypes()->get($this->order_type)?->getLabel();
    }

    public function getOrderDatetimeAttribute($value)
    {
        return make_carbon($this->order_date)->setTimeFromTimeString($this->order_time ?? '00:00:00');
    }

    public function getFormattedAddressAttribute($value)
    {
        return $this->address ? $this->address->formatted_address : null;
    }

    //
    // Helpers
    //

    public function getUrl(?string $page, $params = []): string
    {
        $defaults = [
            'id' => $this->getKey(),
            'hash' => $this->hash,
        ];

        $params = is_null($params)
            ? []
            : array_merge($defaults, $params);

        return page_url($page, $params);
    }

    public function isCompleted(): bool
    {
        return $this->isPaymentProcessed() && $this->hasStatus(setting('completed_order_status'));
    }

    public function isCanceled(): bool
    {
        return $this->hasStatus(setting('canceled_order_status'));
    }

    public function isCancelable()
    {
        if (!$timeout = $this->location->getOrderCancellationTimeout($this->order_type)) {
            return false;
        }

        if ($this->order_datetime->isPast()) {
            return false;
        }

        return now()->diffInRealMinutes($this->order_datetime) > $timeout;
    }

    /**
     * Check if an order was successfully placed
     *
     * @param int $order_id
     *
     * @return bool TRUE on success, or FALSE on failure
     */
    public function isPaymentProcessed(): bool
    {
        return $this->processed && !empty($this->status_id);
    }

    public function isDeliveryType(): bool
    {
        return $this->order_type == static::DELIVERY;
    }

    public function isCollectionType(): bool
    {
        return $this->order_type == static::COLLECTION;
    }

    /**
     * Return the dates of all orders
     */
    public function getOrderDates(): Collection
    {
        return $this->pluckDates('created_at');
    }

    public function markAsCanceled(array $statusData = [])
    {
        $canceled = false;
        if ($this->addStatusHistory(setting('canceled_order_status'), $statusData)) {
            $canceled = true;
            OrderCanceledEvent::dispatch($this);
        }

        return $canceled;
    }

    public function markAsPaymentProcessed()
    {
        if (!$this->processed) {
            OrderBeforePaymentProcessedEvent::dispatch($this);

            $this->processed = true;
            $this->saveQuietly();

            OrderPaymentProcessedEvent::dispatch($this);
        }

        return $this->processed;
    }

    public function logPaymentAttempt($message, $isSuccess, $request = [], $response = [], $isRefundable = false): void
    {
        PaymentLog::logAttempt($this, $message, $isSuccess, $request, $response, $isRefundable);
    }

    public function updateOrderStatus($id, array $options = []): StatusHistory|false
    {
        $id = $id ?: $this->status_id ?: setting('default_order_status');

        /** @var null|Status $status */
        $status = Status::find($id);

        return $this->addStatusHistory($status, $options);
    }

    #[Override]
    public function getMorphClass(): string
    {
        return 'orders';
    }

    //
    // Mail
    //

    public function mailGetRecipients($type): array
    {
        $recipients = [];
        if (in_array($type, (array)setting('order_email', []))) {
            switch ($type) {
                case 'customer':
                    $recipients[] = [$this->email, $this->customer_name];
                    break;
                case 'location':
                    $recipients[] = [$this->location->location_email, $this->location->location_name];
                    break;
                case 'admin':
                    $recipients[] = [setting('site_email'), setting('site_name')];
                    break;
            }
        }

        return $recipients;
    }

    public function mailGetReplyTo($type): array
    {
        $replyTo = [];
        if (in_array($type, (array)setting('order_email', []))) {
            switch ($type) {
                case 'location':
                case 'admin':
                    $replyTo = [$this->email, $this->customer_name];
                    break;
            }
        }

        return $replyTo;
    }

    /**
     * Return the order data to build mail template
     */
    public function mailGetData(): array
    {
        $model = $this->fresh();

        $data = $model->toArray();
        $data['order'] = $model;
        $data['order_number'] = $model->order_id;
        $data['order_id'] = $model->order_id;
        $data['first_name'] = $model->first_name;
        $data['last_name'] = $model->last_name;
        $data['customer_name'] = $model->customer_name;
        $data['email'] = $model->email;
        $data['telephone'] = $model->telephone;
        $data['order_comment'] = $model->comment;
        $data['delivery_comment'] = $model->delivery_comment;

        $data['order_type'] = $model->order_type_name;
        $data['order_time'] = Carbon::createFromTimeString($model->order_time)->isoFormat(lang('system::lang.moment.time_format'));
        $data['order_date'] = $model->order_date->isoFormat(lang('system::lang.moment.date_format'));
        $data['order_added'] = $model->created_at->isoFormat(lang('system::lang.moment.date_time_format'));

        $data['invoice_id'] = $model->invoice_number;
        $data['invoice_number'] = $model->invoice_number;
        $data['invoice_date'] = $model->invoice_date ? $model->invoice_date->isoFormat(lang('system::lang.moment.date_format')) : null;

        $data['order_payment'] = $model->payment_method->name ?? lang('igniter.cart::default.orders.text_no_payment');

        $data['order_menus'] = [];
        $menus = $model->getOrderMenusWithOptions();
        foreach ($menus as $menu) {
            $optionData = [];
            foreach ($menu->menu_options as $menuItemOptionGroupName => $menuItemOptions) {
                $optionData[] = $menuItemOptionGroupName;
                foreach ($menuItemOptions as $menuItemOption) {
                    $optionData[] = $menuItemOption->quantity
                        .'&nbsp;'.lang('igniter::admin.text_times').'&nbsp;'
                        .$menuItemOption->order_option_name
                        .lang('igniter::admin.text_equals')
                        .currency_format(max(0, $menuItemOption->quantity - $menuItemOption->free_qty) * $menuItemOption->order_option_price);
                }
            }

            $data['order_menus'][] = [
                'menu_name' => $menu->name,
                'menu_quantity' => $menu->quantity,
                'menu_price' => currency_format($menu->price),
                'menu_subtotal' => currency_format($menu->subtotal),
                'menu_options' => implode('<br /> ', $optionData),
                'menu_comment' => $menu->comment,
            ];
        }

        $data['order_totals'] = [];
        $orderTotals = $model->getOrderTotals();
        foreach ($orderTotals as $total) {
            $data['order_totals'][] = [
                'order_total_title' => htmlspecialchars_decode((string)$total->title),
                'order_total_value' => currency_format($total->value),
                'priority' => $total->priority,
            ];
        }

        $data['order_address'] = lang('igniter.cart::default.orders.text_collection_order_type');
        if ($model->address) {
            $data['order_address'] = format_address($model->address->toArray(), false);
        }

        if ($model->location) {
            $data['location_logo'] = $model->location->thumb;
            $data['location_name'] = $model->location->location_name;
            $data['location_email'] = $model->location->location_email;
            $data['location_telephone'] = $model->location->location_telephone;
            $data['location_address'] = format_address($model->location->getAddress());
        }

        /** @var null|StatusHistory $statusHistory */
        $statusHistory = StatusHistory::applyRelated($model)->whereStatusIsLatest($model->status_id)->first();
        $data['status_name'] = $statusHistory?->status?->status_name;
        $data['status_comment'] = $statusHistory?->comment;

        $controller = MainController::getController();
        $data['order_view_url'] = $controller->pageUrl('account/order', [
            'hash' => $model->hash,
        ]);

        $this->fireEvent('model.mailGetData', [&$data]);

        return $data;
    }
}
