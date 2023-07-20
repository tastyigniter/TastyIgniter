<?php

namespace Admin\Models;

use Admin\Traits\Assignable;
use Admin\Traits\HasInvoice;
use Admin\Traits\Locationable;
use Admin\Traits\LogsStatusHistory;
use Admin\Traits\ManagesOrderItems;
use Carbon\Carbon;
use Igniter\Flame\Auth\Models\User;
use Igniter\Flame\Database\Casts\Serialize;
use Igniter\Flame\Database\Model;
use Illuminate\Support\Facades\Request;
use Main\Classes\MainController;
use System\Traits\SendsMailTemplate;

/**
 * Orders Model Class
 */
class Orders_model extends Model
{
    use HasInvoice;
    use ManagesOrderItems;
    use LogsStatusHistory;
    use SendsMailTemplate;
    use Locationable;
    use Assignable;

    const DELIVERY = 'delivery';

    const COLLECTION = 'collection';

    /**
     * @var string The database table name
     */
    protected $table = 'orders';

    /**
     * @var string The database table primary key
     */
    protected $primaryKey = 'order_id';

    protected $timeFormat = 'H:i';

    public $guarded = ['ip_address', 'user_agent', 'hash', 'total_items', 'order_total'];

    protected $hidden = ['cart'];

    /**
     * @var array The model table column to convert to dates on insert/update
     */
    public $timestamps = true;

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
            'customer' => 'Admin\Models\Customers_model',
            'location' => 'Admin\Models\Locations_model',
            'address' => 'Admin\Models\Addresses_model',
            'payment_method' => ['Admin\Models\Payments_model', 'foreignKey' => 'payment', 'otherKey' => 'code'],
        ],
        'hasMany' => [
            'payment_logs' => 'Admin\Models\Payment_logs_model',
        ],
    ];

    public static $allowedSortingColumns = [
        'order_id asc', 'order_id desc',
        'created_at asc', 'created_at desc',
    ];

    public function listCustomerAddresses()
    {
        if (!$this->customer)
            return [];

        return $this->customer->addresses()->get();
    }

    //
    // Events
    //

    protected function beforeCreate()
    {
        $this->generateHash();

        $this->ip_address = Request::getClientIp();
        $this->user_agent = Request::userAgent();
    }

    //
    // Scopes
    //

    public function scopeListFrontEnd($query, $options = [])
    {
        extract(array_merge([
            'customer' => null,
            'dateTimeFilter' => [],
            'location' => null,
            'sort' => 'address_id desc',
            'search' => '',
            'status' => null,
            'page' => 1,
            'pageLimit' => 20,
        ], $options));

        $searchableFields = ['order_id', 'first_name', 'last_name', 'email', 'telephone'];

        if (is_null($status)) {
            $query->where('status_id', '>=', 1);
        } else {
            if (!is_array($status))
                $status = [$status];

            $query->whereIn('status_id', $status);
        }

        if ($location instanceof Locations_model) {
            $query->where('location_id', $location->getKey());
        } elseif (strlen($location)) {
            $query->where('location_id', $location);
        }

        if ($customer instanceof User) {
            $query->where('customer_id', $customer->getKey());
        } elseif (strlen($customer)) {
            $query->where('customer_id', $customer);
        }

        if (!is_array($sort)) {
            $sort = [$sort];
        }

        foreach ($sort as $_sort) {
            if (in_array($_sort, self::$allowedSortingColumns)) {
                $parts = explode(' ', $_sort);
                if (count($parts) < 2) {
                    array_push($parts, 'desc');
                }
                [$sortField, $sortDirection] = $parts;
                $query->orderBy($sortField, $sortDirection);
            }
        }

        $search = trim($search);
        if (strlen($search)) {
            $query->search($search, $searchableFields);
        }

        $startDateTime = array_get($dateTimeFilter, 'orderDateTime.startAt', false);
        $endDateTime = array_get($dateTimeFilter, 'orderDateTime.endAt', false);
        if ($startDateTime && $endDateTime)
            $query = $this->scopeWhereBetweenOrderDateTime($query, Carbon::parse($startDateTime)->format('Y-m-d H:i:s'), Carbon::parse($endDateTime)->format('Y-m-d H:i:s'));

        $this->fireEvent('model.extendListFrontEndQuery', [$query]);

        return $query->paginate($pageLimit, $page);
    }

    public function scopeWhereBetweenOrderDateTime($query, $start, $end)
    {
        $query->whereRaw('ADDTIME(order_date, order_time) between ? and ?', [$start, $end]);

        return $query;
    }

    //
    // Accessors & Mutators
    //

    public function getCustomerNameAttribute($value)
    {
        return $this->first_name.' '.$this->last_name;
    }

    public function getOrderTypeNameAttribute()
    {
        if (!$this->location)
            return $this->order_type;

        return optional(
            $this->location->availableOrderTypes()->get($this->order_type)
        )->getLabel();
    }

    public function getOrderDatetimeAttribute($value)
    {
        if (!isset($this->attributes['order_date'])
            && !isset($this->attributes['order_time'])
        ) return null;

        return make_carbon($this->attributes['order_date'])
            ->setTimeFromTimeString($this->attributes['order_time']);
    }

    public function getFormattedAddressAttribute($value)
    {
        return $this->address ? $this->address->formatted_address : null;
    }

    //
    // Helpers
    //

    public function isCompleted()
    {
        if (!$this->isPaymentProcessed())
            return false;

        return $this->hasStatus(setting('completed_order_status'));
    }

    public function isCanceled()
    {
        return $this->hasStatus(setting('canceled_order_status'));
    }

    public function isCancelable()
    {
        if (!$timeout = $this->location->getOrderCancellationTimeout($this->order_type))
            return false;

        if (!$this->order_datetime->isFuture())
            return false;

        return $this->order_datetime->diffInRealMinutes() > $timeout;
    }

    /**
     * Check if an order was successfully placed
     *
     * @param int $order_id
     *
     * @return bool TRUE on success, or FALSE on failure
     */
    public function isPaymentProcessed()
    {
        return $this->processed && !empty($this->status_id);
    }

    public function isDeliveryType()
    {
        return $this->order_type == static::DELIVERY;
    }

    public function isCollectionType()
    {
        return $this->order_type == static::COLLECTION;
    }

    /**
     * Return the dates of all orders
     *
     * @return array
     */
    public function getOrderDates()
    {
        return $this->pluckDates('created_at');
    }

    public function markAsCanceled(array $statusData = [])
    {
        $canceled = false;
        if ($this->addStatusHistory(setting('canceled_order_status'), $statusData)) {
            $canceled = true;

            $this->fireSystemEvent('admin.order.canceled');
        }

        return $canceled;
    }

    public function markAsPaymentProcessed()
    {
        if (!$this->processed) {
            $this->fireSystemEvent('admin.order.beforePaymentProcessed');

            $this->processed = 1;
            $this->save();

            $this->fireSystemEvent('admin.order.paymentProcessed');
        }

        return $this->processed;
    }

    public function logPaymentAttempt($message, $isSuccess, $request = [], $response = [], $isRefundable = false)
    {
        Payment_logs_model::logAttempt($this, $message, $isSuccess, $request, $response, $isRefundable);
    }

    public function updateOrderStatus($id, $options = [])
    {
        $id = $id ?: $this->status_id ?: setting('default_order_status');

        return $this->addStatusHistory(
            Statuses_model::find($id), $options
        );
    }

    /**
     * Generate a unique hash for this order.
     * @return string
     */
    protected function generateHash()
    {
        $this->hash = $this->createHash();
        while ($this->newQuery()->where('hash', $this->hash)->count() > 0) {
            $this->hash = $this->createHash();
        }
    }

    /**
     * Create a hash for this order.
     * @return string
     */
    protected function createHash()
    {
        return md5(uniqid('order', microtime()));
    }

    //
    // Mail
    //

    public function mailGetRecipients($type)
    {
        $emailSetting = setting('order_email');
        is_array($emailSetting) || $emailSetting = [];

        $recipients = [];
        if (in_array($type, $emailSetting)) {
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

    public function mailGetReplyTo($type)
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
     *
     * @return array
     */
    public function mailGetData()
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

        $data['order_type'] = $model->order_type_name;
        $data['order_time'] = Carbon::createFromTimeString($model->order_time)->isoFormat(lang('system::lang.moment.time_format'));
        $data['order_date'] = $model->order_date->isoFormat(lang('system::lang.moment.date_format'));
        $data['order_added'] = $model->created_at->isoFormat(lang('system::lang.moment.date_time_format'));

        $data['invoice_id'] = $model->invoice_number;
        $data['invoice_number'] = $model->invoice_number;
        $data['invoice_date'] = $model->invoice_date ? $model->invoice_date->isoFormat(lang('system::lang.moment.date_format')) : null;

        $data['order_payment'] = $model->payment_method->name ?? lang('admin::lang.orders.text_no_payment');

        $data['order_menus'] = [];
        $menus = $model->getOrderMenusWithOptions();
        foreach ($menus as $menu) {
            $optionData = [];
            foreach ($menu->menu_options->groupBy('order_option_group') as $menuItemOptionGroupName => $menuItemOptions) {
                $optionData[] = $menuItemOptionGroupName;
                foreach ($menuItemOptions as $menuItemOption) {
                    $optionData[] = $menuItemOption->quantity
                        .'&nbsp;'.lang('admin::lang.text_times').'&nbsp;'
                        .$menuItemOption->order_option_name
                        .lang('admin::lang.text_equals')
                        .currency_format($menuItemOption->quantity * $menuItemOption->order_option_price);
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
                'order_total_title' => htmlspecialchars_decode($total->title),
                'order_total_value' => currency_format($total->value),
                'priority' => $total->priority,
            ];
        }

        $data['order_address'] = lang('admin::lang.orders.text_collection_order_type');
        if ($model->address)
            $data['order_address'] = format_address($model->address->toArray(), false);

        if ($model->location) {
            $data['location_logo'] = $model->location->thumb;
            $data['location_name'] = $model->location->location_name;
            $data['location_email'] = $model->location->location_email;
            $data['location_telephone'] = $model->location->location_telephone;
            $data['location_address'] = format_address($model->location->getAddress());
        }

        $statusHistory = Status_history_model::applyRelated($model)->whereStatusIsLatest($model->status_id)->first();
        $data['status_name'] = $statusHistory ? optional($statusHistory->status)->status_name : null;
        $data['status_comment'] = $statusHistory ? $statusHistory->comment : null;

        $controller = MainController::getController() ?: new MainController;
        $data['order_view_url'] = $controller->pageUrl('account/order', [
            'hash' => $model->hash,
        ]);

        return $data;
    }
}
