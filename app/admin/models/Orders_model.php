<?php namespace Admin\Models;

use Admin\Traits\HasInvoice;
use Admin\Traits\Locationable;
use Admin\Traits\LogsStatusHistory;
use Admin\Traits\ManagesOrderItems;
use Event;
use Igniter\Flame\Auth\Models\User;
use Main\Classes\MainController;
use Model;
use Request;
use System\Traits\SendsMailTemplate;

/**
 * Orders Model Class
 *
 * @package Admin
 */
class Orders_model extends Model
{
    use HasInvoice;
    use ManagesOrderItems;
    use LogsStatusHistory;
    use SendsMailTemplate;
    use Locationable;

    const CREATED_AT = 'date_added';

    const UPDATED_AT = 'date_modified';

    const DELIVERY = 'delivery';

    const COLLECTION = 'collection';

    protected static $orderTypes = [1 => self::DELIVERY, 2 => self::COLLECTION];

    /**
     * @var string The database table name
     */
    protected $table = 'orders';

    /**
     * @var string The database table primary key
     */
    protected $primaryKey = 'order_id';

    protected $guarded = ['*'];

    protected $fillable = ['customer_id', 'first_name', 'last_name', 'email', 'telephone', 'location_id', 'address_id',
        'cart', 'total_items', 'comment', 'payment', 'order_type', 'order_time', 'order_date', 'order_total',
        'status_id', 'ip_address', 'user_agent', 'notify', 'assignee_id',
    ];

    protected $timeFormat = 'H:i';

    /**
     * @var array The model table column to convert to dates on insert/update
     */
    public $timestamps = TRUE;

    public $casts = [
        'cart' => 'serialize',
        'order_date' => 'date',
        'order_time' => 'time',
        'invoice_date' => 'dateTime',
    ];

    public $relation = [
        'belongsTo' => [
            'customer' => 'Admin\Models\Customers_model',
            'location' => 'Admin\Models\Locations_model',
            'address' => 'Admin\Models\Addresses_model',
            'status' => 'Admin\Models\Statuses_model',
            'assignee' => ['Admin\Models\Staffs_model', 'foreignKey' => 'assignee_id'],
            'payment_method' => ['Admin\Models\Payments_model', 'foreignKey' => 'payment', 'otherKey' => 'code'],
            'payment_logs' => 'Admin\Models\Payment_logs_model',
            'coupon_history' => 'Admin\Models\Coupons_history_model',
        ],
        'morphMany' => [
            'review' => ['Admin\Models\Reviews_model'],
            'status_history' => ['Admin\Models\Status_history_model', 'name' => 'object'],
        ],
    ];

    public $appends = ['customer_name', 'order_type_name'];

    public static $allowedSortingColumns = [
        'order_id asc', 'order_id desc',
        'date_added asc', 'date_added desc',
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

    public function beforeCreate()
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
            'page' => 1,
            'pageLimit' => 20,
            'customer' => null,
            'location' => null,
            'sort' => 'address_id desc',
        ], $options));

        $query->where('status_id', '>=', 1);

        if ($location instanceof Locations_model) {
            $query->where('location_id', $location->getKey());
        }
        else if (strlen($location)) {
            $query->where('location_id', $location);
        }

        if ($customer instanceof User) {
            $query->where('customer_id', $customer->getKey());
        }
        else if (strlen($customer)) {
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
                list($sortField, $sortDirection) = $parts;
                $query->orderBy($sortField, $sortDirection);
            }
        }

        return $query->paginate($pageLimit, $page);
    }

    //
    // Accessors & Mutators
    //

    public function getCustomerNameAttribute($value)
    {
        return $this->first_name.' '.$this->last_name;
    }

    public function getOrderTypeAttribute($value)
    {
        if (isset(self::$orderTypes[$value]))
            return self::$orderTypes[$value];

        return $value;
    }

    public function getOrderTypeNameAttribute()
    {
        return ucwords($this->order_type);
    }

    public function getFormattedAddressAttribute($value)
    {
        return $this->address ? $this->address->formatted_address : null;
    }

    //
    // Helpers
    //

    /**
     * Check if an order was successfully placed
     *
     * @param int $order_id
     *
     * @return bool TRUE on success, or FALSE on failure
     */
    public function isPaymentProcessed()
    {
        return $this->processed;
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
        return $this->pluckDates('date_added');
    }

    public function markAsPaymentProcessed()
    {
        if ($this->processed)
            return TRUE;

        $this->processed = 1;
        $this->save();

        Event::fire('admin.order.paymentProcessed', [$this]);

        return $this->processed;
    }

    public function logPaymentAttempt($message, $status, $request = [], $response = [])
    {
        $record = new Payment_logs_model;
        $record->message = $message;
        $record->order_id = $this->order_id;
        $record->payment_name = $this->payment_method->code;
        $record->status = $status;

        $record->request = $request;
        $record->response = $response;

        $record->save();
    }

    public function updateOrderStatus($id, $options = [])
    {
        if (!$status = Statuses_model::find($id)) {
            return;
        }

        return $this->addStatusHistory($status, $options);
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
        is_array($emailSetting) OR $emailSetting = [];

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

    /**
     * Return the order data to build mail template
     *
     * @return array
     */
    public function mailGetData()
    {
        $data = [];

        $model = $this->fresh();
        $data['order_number'] = $model->order_id;
        $data['first_name'] = $model->first_name;
        $data['last_name'] = $model->last_name;
        $data['customer_name'] = $model->customer_name;
        $data['email'] = $model->email;
        $data['telephone'] = $model->telephone;
        $data['order_comment'] = $model->comment;

        $data['order_type'] = ($model->order_type == '1') ? 'delivery' : 'collection';
        $data['order_time'] = $model->order_time.' '.$model->order_date->format('d M');
        $data['order_date'] = $model->date_added->format('d M y');

        $data['invoice_id'] = $model->invoice_id;
        $data['invoice_date'] = $model->invoice_date ? $model->invoice_date->format('d M y') : null;

        $data['order_payment'] = ($model->payment_method)
            ? $model->payment_method->name
            : lang('admin::lang.orders.text_no_payment');

        $data['order_menus'] = [];
        $menus = $model->getOrderMenus();
        $menuOptions = $model->getOrderMenuOptions();
        foreach ($menus as $menu) {

            $optionData = [];
            if ($menuItemOptions = $menuOptions->get($menu->menu_id)) {
                foreach ($menuItemOptions as $menuItemOption) {
                    $optionData[] = $menuItemOption->order_option_name
                        .lang('admin::lang.text_equals')
                        .currency_format($menuItemOption->order_option_price);
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
            $data['order_address'] = format_address($model->address->toArray());

        if ($model->location) {
            $data['location_name'] = $model->location->location_name;
            $data['location_email'] = $model->location->location_email;
        }

        $status = $model->status()->first();
        $data['status_name'] = $status ? $status->status_name : null;
        $data['status_comment'] = $status ? $status->status_comment : null;

        $controller = MainController::getController() ?: new MainController;
        $data['order_view_url'] = $controller->pageUrl('account/orders', [
            'orderId' => $model->order_id,
        ]);

        return $data;
    }
}