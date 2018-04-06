<?php namespace Admin\Models;

use Carbon\Carbon;
use Igniter\Flame\Location\Models\Location;
use Main\Classes\MainController;
use Model;
use Request;
use System\Traits\SendsMailTemplate;

/**
 * Reservations Model Class
 *
 * @package Admin
 */
class Reservations_model extends Model
{
    use SendsMailTemplate;

    const CREATED_AT = 'date_added';

    const UPDATED_AT = 'date_modified';

    /**
     * @var string The database table name
     */
    protected $table = 'reservations';

    /**
     * @var string The database table primary key
     */
    protected $primaryKey = 'reservation_id';

    /**
     * @var array The model table column to convert to dates on insert/update
     */
    public $timestamps = TRUE;

    public $timeFormat = 'H:i';

    public $guarded = ['ip_address', 'user_agent', 'hash'];

    public $relation = [
        'belongsTo' => [
            'related_table'  => ['Admin\Models\Tables_model', 'foreignKey' => 'table_id'],
            'location'       => 'Admin\Models\Locations_model',
            'related_status' => ['Admin\Models\Statuses_model', 'foreignKey' => 'status'],
            'assignee'       => ['Admin\Models\Staffs_model', 'foreignKey' => 'assignee_id'],
        ],
        'morphMany' => [
            'status_history' => ['Admin\Models\Status_history_model', 'name' => 'object'],
        ],
    ];

    public $casts = [
        'reserve_time' => 'time',
        'reserve_date' => 'date',
    ];

    public static $allowedSortingColumns = [
        'reservation_id asc', 'reservation_id desc',
        'reserve_date asc', 'reserve_date desc',
    ];

    protected static $previewPageName;

    public function setPreviewPageName($pageName)
    {
        self::$previewPageName = $pageName;
    }

    public function getPreviewPageUrl()
    {
        $controller = MainController::getController() ?: new MainController;

        $pageName = self::$previewPageName;

        return $controller->pageUrl($pageName, $this->getUrlParams());
    }

    public function getUrlParams()
    {
        return [
            'reservationId' => $this->reservation_id,
            'hash'          => $this->hash,
        ];
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
            'page'      => 1,
            'pageLimit' => 20,
            'sort'      => 'address_id desc',
            'customer'  => null,
            'location'  => null,
        ], $options));

        if ($location instanceof Location) {
            $query->where('location_id', $location->getKey());
        }
        else if (strlen($location)) {
            $query->where('location_id', $location);
        }

        if ($customer instanceof Customers_model) {
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

    public function scopeWhereBetweenPeriod($query, $start, $end)
    {
        $query->whereRaw('ADDTIME(reserve_date, reserve_time) between ? and ?', [$start, $end]);

        return $query;
    }

    //
    // Accessors & Mutators
    //

    public function getCustomerNameAttribute($value)
    {
        return $this->first_name.' '.$this->last_name;
    }

    public function getDurationAttribute($value)
    {
        if (!is_null($value))
            return $value;

        if (!$location = $this->location)
            return $value;

        return $location->reservation_stay_time;
    }

    public function getReserveEndTimeAttribute($value)
    {
        if ($this->duration)
            return $this->reserve_time->copy()->addMinutes($this->duration);

        return $this->reserve_time->copy()->endOfDay();
    }

    public function getReservationDatetimeAttribute($value)
    {
        return Carbon::createFromFormat(
            'Y-m-d H:i:s',
            "{$this->attributes['reserve_date']} {$this->attributes['reserve_time']}"
        );
    }

    public function getReservationEndDatetimeAttribute($value)
    {
        if ($this->duration)
            return $this->reservation_datetime->copy()->addMinutes($this->duration);

        return $this->reservation_datetime->copy()->endOfDay();
    }

    public function getOccasionAttribute()
    {
        $occasions = $this->getOccasionOptions();

        return isset($occasions[$this->occasion_id]) ? $occasions[$this->occasion_id] : $occasions[0];
    }

    public function getTableNameAttribute()
    {
        return isset($this->related_table) ? $this->related_table->table_name : null;
    }

    //
    // Helpers
    //

    public static function listCalendarEvents($startAt, $endAt)
    {
        $collection = self::whereBetween('reserve_date', [
            date('Y-m-d H:i:s', strtotime($startAt)),
            date('Y-m-d H:i:s', strtotime($endAt)),
        ])->get();

        $collection->transform(function ($reservation) {
            return $reservation->getEventDetails();
        });

        return $collection->toArray();
    }

    public function getEventDetails()
    {
        $status = $this->related_status;
        $table = $this->related_table;

        return [
            'id'               => $this->getKey(),
            'title'            => $this->customer_name,
            'start'            => $this->reservation_datetime->toIso8601String(),
            'end'              => $this->reservation_end_datetime->toIso8601String(),
            'allDay'           => $this->isReservedAllDay(),
            'color'            => $status->status_color,
            'location_name'    => ($location = $this->location) ? $location->location_name : null,
            'first_name'       => $this->first_name,
            'last_name'        => $this->last_name,
            'email'            => $this->email,
            'telephone'        => $this->telephone,
            'last_name'        => $this->last_name,
            'guest_num'        => $this->guest_num,
            'reserve_date'     => $this->reserve_date->toDateString(),
            'reserve_time'     => $this->reserve_time->toTimeString(),
            'reserve_end_time' => $this->reserve_end_time->toTimeString(),
            'duration'         => $this->duration,
            'status'           => $status ? $status->toArray() : [],
            'table'            => $table ? $table->toArray() : [],
        ];
    }

    public function isReservedAllDay()
    {
        $diffInHours = $this->reservation_datetime->diffInHours($this->reservation_end_datetime);

        return $diffInHours >= 23 OR $diffInHours == 0;
    }

    public function getStatusColor()
    {
        $status = $this->related_status()->first();
        if (!$status)
            return null;

        return $status->status_color;
    }

    public function getOccasionOptions()
    {
        return [
            'not applicable',
            'birthday',
            'anniversary',
            'general celebration',
            'hen party',
            'stag party',
        ];
    }

    /**
     * Return the dates of all reservations
     *
     * @return array
     */
    public function getReservationDates()
    {
        return $this->pluckDates('reserve_date');
    }

    /**
     * Add order status to status history
     *
     * @param array $statusData
     *
     * @return mixed
     */
    public function addStatusHistory(array $statusData = [])
    {
        if (!$this->exists OR !$this->related_status)
            return;

        $status = $this->related_status->toArray();

        $statusHistory = $this->status_history()->updateOrCreate([
            'status_for' => array_get($statusData, 'status_for', array_get($status, 'status_for')),
            'status_id'  => array_get($statusData, 'status_id', array_get($status, 'status_id')),
        ], [
            'staff_id'    => array_get($statusData, 'staff_id'),
            'assignee_id' => array_get($statusData, 'assignee_id', $this->assignee_id),
            'notify'      => array_get($statusData, 'notify', array_get($status, 'status_notify')),
            'comment'     => strlen($comment = array_get($statusData, 'comment')) ? $comment : array_get($status, 'status_comment'),
        ]);

        return $statusHistory;
    }

    /**
     * Generate a unique hash for this reservation.
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
     * Create a hash for this reservation.
     * @return string
     */
    protected function createHash()
    {
        return md5(uniqid('reservation', microtime()));
    }

    //
    // Mail
    //

    public function mailGetRecipients($type)
    {
        $emailSetting = setting('reservation_email', []);
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

        $data['reservation_number'] = $this->reservation_id;
        $data['reservation_view_url'] = $this->getPreviewPageUrl();
        $data['reservation_time'] = $this->reserve_time->format('H:i');
        $data['reservation_date'] = $this->reserve_date->format('l, F j, Y');
        $data['reservation_guest_no'] = $this->guest_num;
        $data['first_name'] = $this->first_name;
        $data['last_name'] = $this->last_name;
        $data['email'] = $this->email;
        $data['telephone'] = $this->telephone;
        $data['reservation_comment'] = $this->comment;

        if ($this->location) {
            $data['location_name'] = $this->location->location_name;
            $data['location_email'] = $this->location->location_email;
        }

        return $data;
    }
}