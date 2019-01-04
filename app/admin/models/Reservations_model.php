<?php namespace Admin\Models;

use Admin\Traits\Locationable;
use Admin\Traits\LogsStatusHistory;
use Carbon\Carbon;
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
    use LogsStatusHistory;
    use SendsMailTemplate;
    use Locationable;

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

    /**
     * The storage format of the model's date columns.
     *
     * @var string
     */
    protected $dateFormat = 'Y-m-d';

    public $timeFormat = 'H:i';

    public $guarded = ['ip_address', 'user_agent', 'hash'];

    public $relation = [
        'belongsTo' => [
            'related_table' => ['Admin\Models\Tables_model', 'foreignKey' => 'table_id'],
            'location' => 'Admin\Models\Locations_model',
            'status' => ['Admin\Models\Statuses_model'],
            'assignee' => ['Admin\Models\Staffs_model', 'foreignKey' => 'assignee_id'],
        ],
        'morphMany' => [
            'status_history' => ['Admin\Models\Status_history_model', 'name' => 'object'],
        ],
    ];

    public $casts = [
        'reserve_time' => 'time',
        'reserve_date' => 'date',
    ];

    public $appends = ['customer_name', 'duration', 'reservation_datetime', 'table_name'];

    public static $allowedSortingColumns = [
        'reservation_id asc', 'reservation_id desc',
        'reserve_date asc', 'reserve_date desc',
    ];

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
            'sort' => 'address_id desc',
            'customer' => null,
            'location' => null,
        ], $options));

        $query->where('status_id', '>=', 1);

        if ($location instanceof Locations_model) {
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
        if (!$this->reservation_datetime)
            return null;

        if ($this->duration)
            return $this->reservation_datetime->copy()->addMinutes($this->duration);

        return $this->reservation_datetime->copy()->endOfDay();
    }

    public function getReservationDatetimeAttribute($value)
    {
        if (!isset($this->attributes['reserve_date'])
            AND !isset($this->attributes['reserve_time'])
        ) return null;

        return Carbon::createFromTimeString(
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

        return $occasions[$this->occasion_id] ?? $occasions[0];
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
        $status = $this->status;
        $table = $this->related_table;

        return [
            'id' => $this->getKey(),
            'title' => $this->customer_name,
            'start' => $this->reservation_datetime->toIso8601String(),
            'end' => $this->reservation_end_datetime->toIso8601String(),
            'allDay' => $this->isReservedAllDay(),
            'color' => $status ? $status->status_color : null,
            'location_name' => ($location = $this->location) ? $location->location_name : null,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'telephone' => $this->telephone,
            'last_name' => $this->last_name,
            'guest_num' => $this->guest_num,
            'reserve_date' => $this->reserve_date->toDateString(),
            'reserve_time' => $this->reserve_time,
            'reserve_end_time' => $this->reserve_end_time->toTimeString(),
            'duration' => $this->duration,
            'status' => $status ? $status->toArray() : [],
            'table' => $table ? $table->toArray() : [],
        ];
    }

    public function isReservedAllDay()
    {
        $diffInHours = $this->reservation_datetime->diffInHours($this->reservation_end_datetime);

        return $diffInHours >= 23 OR $diffInHours == 0;
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

        $model = $this->fresh();
        $data['reservation_number'] = $model->reservation_id;
        $data['reservation_time'] = $model->reserve_time;
        $data['reservation_date'] = $model->reserve_date->format('l, F j, Y');
        $data['reservation_guest_no'] = $model->guest_num;
        $data['first_name'] = $model->first_name;
        $data['last_name'] = $model->last_name;
        $data['email'] = $model->email;
        $data['telephone'] = $model->telephone;
        $data['reservation_comment'] = $model->comment;

        if ($model->location) {
            $data['location_name'] = $model->location->location_name;
            $data['location_email'] = $model->location->location_email;
        }

        $status = $model->status()->first();
        $data['status_name'] = $status ? $status->status_name : null;
        $data['status_comment'] = $status ? $status->status_comment : null;

        $controller = MainController::getController() ?: new MainController;
        $data['reservation_view_url'] = $controller->pageUrl('account/reservations', [
            'reservationId' => $model->reservation_id,
        ]);

        return $data;
    }
}