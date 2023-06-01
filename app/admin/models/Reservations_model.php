<?php

namespace Admin\Models;

use Admin\Traits\Assignable;
use Admin\Traits\Locationable;
use Admin\Traits\LogsStatusHistory;
use Carbon\Carbon;
use Igniter\Flame\Database\Model;
use Igniter\Flame\Database\Traits\Purgeable;
use Illuminate\Support\Facades\Request;
use Main\Classes\MainController;
use System\Traits\SendsMailTemplate;

/**
 * Reservations Model Class
 */
class Reservations_model extends Model
{
    use Purgeable;
    use LogsStatusHistory;
    use SendsMailTemplate;
    use Locationable;
    use Assignable;

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
    public $timestamps = true;

    /**
     * The storage format of the model's date columns.
     *
     * @var string
     */
    protected $dateFormat = 'Y-m-d';

    protected $timeFormat = 'H:i';

    public $guarded = ['ip_address', 'user_agent', 'hash'];

    protected $casts = [
        'location_id' => 'integer',
        'table_id' => 'integer',
        'guest_num' => 'integer',
        'occasion_id' => 'integer',
        'assignee_id' => 'integer',
        'reserve_time' => 'time',
        'reserve_date' => 'date',
        'notify' => 'boolean',
        'duration' => 'integer',
        'processed' => 'boolean',
    ];

    public $relation = [
        'belongsTo' => [
            'customer' => 'Admin\Models\Customers_model',
            'related_table' => ['Admin\Models\Tables_model', 'foreignKey' => 'table_id'],
            'location' => 'Admin\Models\Locations_model',
        ],
        'belongsToMany' => [
            'tables' => ['Admin\Models\Tables_model', 'table' => 'reservation_tables'],
        ],
    ];

    protected $purgeable = ['tables'];

    public $appends = ['customer_name', 'duration', 'table_name', 'reservation_datetime', 'reservation_end_datetime'];

    public static $allowedSortingColumns = [
        'reservation_id asc', 'reservation_id desc',
        'reserve_date asc', 'reserve_date desc',
    ];

    //
    // Events
    //

    protected function beforeCreate()
    {
        $this->generateHash();

        $this->ip_address = Request::getClientIp();
        $this->user_agent = Request::userAgent();
    }

    protected function afterSave()
    {
        $this->restorePurgedValues();

        if (array_key_exists('tables', $this->attributes)) {
            $this->addReservationTables((array)$this->attributes['tables']);
        }

        if ($this->location->getOption('auto_allocate_table', 1) && !$this->tables()->count()) {
            $this->addReservationTables($this->getNextBookableTable()->pluck('table_id')->all());
        }
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
            'status' => null,
            'search' => '',
            'dateTimeFilter' => [],
        ], $options));

        $searchableFields = ['reservation_id', 'first_name', 'last_name', 'email', 'telephone'];

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

        if ($customer instanceof Customers_model) {
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

        $startDateTime = array_get($dateTimeFilter, 'reservationDateTime.startAt', false);
        $endDateTime = array_get($dateTimeFilter, 'reservationDateTime.endAt', false);
        if ($startDateTime && $endDateTime)
            $query = $this->scopeWhereBetweenReservationDateTime($query, Carbon::parse($startDateTime)->format('Y-m-d H:i:s'), Carbon::parse($endDateTime)->format('Y-m-d H:i:s'));

        $this->fireEvent('model.extendListFrontEndQuery', [$query]);

        return $query->paginate($pageLimit, $page);
    }

    public function scopeWhereBetweenReservationDateTime($query, $start, $end)
    {
        $query->whereRaw('ADDTIME(reserve_date, reserve_time) between ? and ?', [$start, $end]);

        return $query;
    }

    public function scopeWhereBetweenDate($query, $dateTime)
    {
        $query->whereRaw(
            '? between DATE_SUB(ADDTIME(reserve_date, reserve_time), INTERVAL (duration - 2) MINUTE)'.
            ' and DATE_ADD(ADDTIME(reserve_date, reserve_time), INTERVAL duration MINUTE)',
            [$dateTime]
        );

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

        return $location->getReservationStayTime();
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
            && !isset($this->attributes['reserve_time'])
        ) return null;

        return make_carbon($this->attributes['reserve_date'])
            ->setTimeFromTimeString($this->attributes['reserve_time']);
    }

    public function getReservationEndDatetimeAttribute($value)
    {
        return $this->reserve_end_time;
    }

    public function getOccasionAttribute()
    {
        $occasions = $this->getOccasionOptions();

        return $occasions[$this->occasion_id] ?? $occasions[0];
    }

    public function getTableNameAttribute()
    {
        return ($this->tables && $this->tables->isNotEmpty())
            ? implode(', ', $this->tables->pluck('table_name')->all())
            : '';
    }

    public function setDurationAttribute($value)
    {
        if (empty($value))
            $value = optional($this->location()->first())->getReservationStayTime();

        $this->attributes['duration'] = $value;
    }

    //
    // Helpers
    //

    public function isCompleted()
    {
        return $this->hasStatus(setting('confirmed_reservation_status'));
    }

    public function isCanceled()
    {
        return $this->hasStatus(setting('canceled_reservation_status'));
    }

    public function isCancelable()
    {
        if (!$timeout = $this->location->getReservationCancellationTimeout())
            return false;

        if (!$this->reservation_datetime->isFuture())
            return false;

        return $this->reservation_datetime->diffInRealMinutes() > $timeout;
    }

    public function markAsCanceled(array $statusData = [])
    {
        $canceled = false;
        if ($this->addStatusHistory(setting('canceled_reservation_status'), $statusData)) {
            $canceled = true;

            $this->fireSystemEvent('admin.reservation.canceled');
        }

        return $canceled;
    }

    public static function findReservedTables($location, $dateTime)
    {
        $query = self::with('tables');
        $query->whereHas('tables', function ($query) use ($location) {
            $query->whereHasLocation($location->getKey());
        });
        $query->whereLocationId($location->getKey());
        $query->whereBetweenDate($dateTime->toDateTimeString());
        $query->whereNotIn('status_id', [0, setting('canceled_reservation_status')]);
        $result = $query->get();

        return $result->pluck('tables')->flatten()->keyBy('table_id');
    }

    public static function listCalendarEvents($startAt, $endAt, $locationId = null)
    {
        $query = self::whereBetween('reserve_date', [
            date('Y-m-d H:i:s', strtotime($startAt)),
            date('Y-m-d H:i:s', strtotime($endAt)),
        ]);

        if (!is_null($locationId))
            $query->whereHasLocation($locationId);

        $collection = $query->get();

        $collection->transform(function ($reservation) {
            return $reservation->getEventDetails();
        });

        return $collection->toArray();
    }

    public function getEventDetails()
    {
        $status = $this->status;
        $tables = $this->tables;

        return [
            'id' => $this->getKey(),
            'title' => $this->table_name.' ('.$this->guest_num.')',
            'start' => $this->reservation_datetime->toIso8601String(),
            'end' => $this->reservation_end_datetime->toIso8601String(),
            'allDay' => $this->isReservedAllDay(),
            'color' => $status ? $status->status_color : null,
            'location_name' => ($location = $this->location) ? $location->location_name : null,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'telephone' => $this->telephone,
            'guest_num' => $this->guest_num,
            'reserve_date' => $this->reserve_date->toDateString(),
            'reserve_time' => $this->reserve_time,
            'reserve_end_time' => $this->reserve_end_time->toTimeString(),
            'duration' => $this->duration,
            'status' => $status ? $status->toArray() : [],
            'tables' => $tables ? $tables->toArray() : [],
        ];
    }

    public function isReservedAllDay()
    {
        $diffInMinutes = $this->reservation_datetime->diffInMinutes($this->reservation_end_datetime);

        return $diffInMinutes >= (60 * 23) || $diffInMinutes == 0;
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

    /**
     * Create new or update existing reservation tables
     *
     * @param array $tableIds if empty all existing records will be deleted
     *
     * @return bool
     */
    public function addReservationTables(array $tableIds = [])
    {
        if (!$this->exists)
            return false;

        $this->tables()->sync($tableIds);
    }

    /**
     * @return \Illuminate\Support\Collection|null
     */
    public function getNextBookableTable()
    {
        $tables = $this->location->tables->where('table_status', 1);

        $reserved = static::findReservedTables($this->location, $this->reservation_datetime);

        $tables = $tables->diff($reserved)->sortBy('priority');

        $result = collect();
        $unseatedGuests = $this->guest_num;
        foreach ($tables as $table) {
            if ($table->min_capacity <= $this->guest_num && $table->max_capacity >= $this->guest_num)
                return collect([$table]);

            if ($table->is_joinable && $unseatedGuests >= $table->min_capacity) {
                $result->push($table);
                $unseatedGuests -= $table->max_capacity;
                if ($unseatedGuests <= 0)
                    break;
            }
        }

        return $unseatedGuests > 0 ? collect() : $result;
    }

    //
    // Mail
    //

    public function mailGetReplyTo($type)
    {
        $replyTo = [];
        if (in_array($type, (array)setting('reservation_email', []))) {
            switch ($type) {
                case 'location':
                case 'admin':
                    $replyTo = [$this->email, $this->customer_name];
                    break;
            }
        }

        return $replyTo;
    }

    public function mailGetRecipients($type)
    {
        $emailSetting = setting('reservation_email', []);
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

    /**
     * Return the order data to build mail template
     *
     * @return array
     */
    public function mailGetData()
    {
        $model = $this->fresh();

        $data = $model->toArray();
        $data['reservation'] = $model;
        $data['reservation_number'] = $model->reservation_id;
        $data['reservation_id'] = $model->reservation_id;
        $data['reservation_time'] = Carbon::createFromTimeString($model->reserve_time)->isoFormat(lang('system::lang.moment.time_format'));
        $data['reservation_date'] = $model->reserve_date->isoFormat(lang('system::lang.moment.date_format_long'));
        $data['reservation_guest_no'] = $model->guest_num;
        $data['first_name'] = $model->first_name;
        $data['last_name'] = $model->last_name;
        $data['email'] = $model->email;
        $data['telephone'] = $model->telephone;
        $data['reservation_comment'] = $model->comment;

        if ($model->location) {
            $data['location_logo'] = $model->location->thumb;
            $data['location_name'] = $model->location->location_name;
            $data['location_email'] = $model->location->location_email;
            $data['location_telephone'] = $model->location->location_telephone;
        }

        $statusHistory = Status_history_model::applyRelated($model)->whereStatusIsLatest($model->status_id)->first();
        $data['status_name'] = $statusHistory ? optional($statusHistory->status)->status_name : null;
        $data['status_comment'] = $statusHistory ? $statusHistory->comment : null;

        $controller = MainController::getController() ?: new MainController;
        $data['reservation_view_url'] = $controller->pageUrl('account/reservations', [
            'reservationId' => $model->reservation_id,
        ]);

        return $data;
    }
}
