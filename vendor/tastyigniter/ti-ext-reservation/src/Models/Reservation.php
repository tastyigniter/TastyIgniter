<?php

declare(strict_types=1);

namespace Igniter\Reservation\Models;

use Carbon\Carbon;
use Igniter\Admin\Models\Concerns\GeneratesHash;
use Igniter\Admin\Models\Concerns\LogsStatusHistory;
use Igniter\Admin\Models\Status;
use Igniter\Admin\Models\StatusHistory;
use Igniter\Flame\Database\Builder;
use Igniter\Flame\Database\Factories\HasFactory;
use Igniter\Flame\Database\Model;
use Igniter\Flame\Database\Relations\BelongsTo;
use Igniter\Flame\Database\Traits\Purgeable;
use Igniter\Local\Models\Concerns\Locationable;
use Igniter\Local\Models\Location;
use Igniter\Main\Classes\MainController;
use Igniter\Reservation\Events\ReservationCanceledEvent;
use Igniter\Reservation\Models\Concerns\LocationAction;
use Igniter\System\Models\Concerns\SendsMailTemplate;
use Igniter\User\Models\Concerns\Assignable;
use Igniter\User\Models\Concerns\HasCustomer;
use Igniter\User\Models\Customer;
use Illuminate\Contracts\Database\Eloquent\Builder as BuilderContract;
use Illuminate\Support\Collection;

/**
 * Reservation Model Class
 *
 * @property int $reservation_id
 * @property int $location_id
 * @property int $table_id
 * @property int $guest_num
 * @property int|null $occasion_id
 * @property int|null $customer_id
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string $telephone
 * @property string|null $comment
 * @property mixed $reserve_time
 * @property Carbon|string $reserve_date
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property int|null $assignee_id
 * @property int|null $assignee_group_id
 * @property bool|null $notify
 * @property string $ip_address
 * @property string $user_agent
 * @property int $status_id
 * @property string|null $hash
 * @property int|null $duration
 * @property bool|null $processed
 * @property \Illuminate\Support\Carbon|null $status_updated_at
 * @property \Illuminate\Support\Carbon|null $assignee_updated_at
 * @property-read mixed $customer_name
 * @property-read mixed $occasion
 * @property-read mixed $reservation_datetime
 * @property-read mixed $reservation_end_datetime
 * @property-read mixed $reserve_end_time
 * @property-read string|null $status_color
 * @property-read string|null $status_name
 * @property-read mixed $table_name
 * @property-read Customer|null $customer
 * @property-read Location|LocationAction|null $location
 * @property-read Status|null $status
 * @property-read Collection<int, DiningTable> $tables
 * @method static Builder<static>|Reservation query()
 * @method static Builder<static>|Reservation with(string|array $with)
 * @method static array pluckDates(string $column, string $keyFormat = 'Y-m', string $valueFormat = 'F Y')
 * @method static BelongsTo|Customer customer()
 * @method static BelongsTo|Location location()
 * @method static BelongsTo|Reservation status()
 * @method static BelongsTo|DiningTable tables()
 * @method static Builder<static>|Reservation whereHash($value)
 * @method static Builder<static>|Reservation whereBetween($column, $values, $boolean = 'and')
 * @method static Builder<static>|Reservation whereHasLocation(int|string|Model $locationId)
 * @method static Builder<static>|Reservation whereBetweenStayTime($dateTime)
 * @method static Builder|Reservation whereBetweenReservationDateTime(string $start, string $end)
 * @mixin Builder
 * @mixin Model
 */
class Reservation extends Model
{
    use Assignable;
    use GeneratesHash;
    use HasCustomer;
    use HasFactory;
    use Locationable;
    use LogsStatusHistory;
    use Purgeable;
    use SendsMailTemplate;

    /**
     * @var string The database table name
     */
    protected $table = 'reservations';

    /**
     * @var string The database table primary key
     */
    protected $primaryKey = 'reservation_id';

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
            'customer' => Customer::class,
            'location' => Location::class,
        ],
        'belongsToMany' => [
            'tables' => [DiningTable::class, 'table' => 'reservation_tables'],
        ],
    ];

    protected $purgeable = ['tables'];

    public $appends = ['customer_name', 'duration', 'table_name', 'reservation_datetime', 'reservation_end_datetime'];

    protected $attributes = [
        'table_id' => 0,
        'status_id' => 0,
    ];

    protected array $queryModifierFilters = [
        'customer' => 'applyCustomer',
        'location' => 'whereHasLocation',
        'status' => 'whereStatus',
        'dateTimeFilter' => 'applyDateTimeFilter',
    ];

    protected array $queryModifierSorts = [
        'reservation_id asc', 'reservation_id desc',
        'reserve_date asc', 'reserve_date desc',
        'created_at asc', 'created_at desc',
    ];

    protected array $queryModifierSearchableFields = ['reservation_id', 'first_name', 'last_name', 'email', 'telephone'];

    //
    // Accessors & Mutators
    //

    public function getCustomerNameAttribute($value): string
    {
        return $this->first_name.' '.$this->last_name;
    }

    public function getDurationAttribute($value)
    {
        return $value ?? $this->location?->getReservationStayTime();
    }

    public function getReserveEndTimeAttribute($value)
    {
        if (!$this->reservation_datetime) {
            return null;
        }

        if ($this->duration) {
            return $this->reservation_datetime->copy()->addMinutes($this->duration);
        }

        return $this->reservation_datetime->copy()->endOfDay();
    }

    public function getReservationDatetimeAttribute($value): ?Carbon
    {
        return $this->reserve_date ? make_carbon($this->reserve_date)->setTimeFromTimeString($this->reserve_time) : null;
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

    public function getTableNameAttribute(): string
    {
        return ($this->tables->isNotEmpty())
            ? $this->tables->map(fn($table) => $table->summary)->join(', ')
            : '';
    }

    public function setDurationAttribute($value): void
    {
        if (empty($value)) {
            $value = $this->location?->getReservationStayTime();
        }

        $this->attributes['duration'] = $value;
    }

    //
    // Helpers
    //

    public function isCompleted(): bool
    {
        return $this->hasStatus(setting('confirmed_reservation_status'));
    }

    public function isCanceled(): bool
    {
        return $this->hasStatus(setting('canceled_reservation_status'));
    }

    public function isCancelable()
    {
        if (!$timeout = $this->location->getReservationCancellationTimeout()) {
            return false;
        }

        if ($this->reservation_datetime->isPast()) {
            return false;
        }

        return now()->diffInRealMinutes($this->reservation_datetime) > $timeout;
    }

    public function markAsCanceled(array $statusData = [])
    {
        $canceled = false;
        if ($this->addStatusHistory(setting('canceled_reservation_status'), $statusData)) {
            $canceled = true;
            ReservationCanceledEvent::dispatch($this);
        }

        return $canceled;
    }

    public static function findReservedTables($locationId, $dateTime)
    {
        return self::query()
            ->with('tables')
            ->whereHas('tables', function(BuilderContract $query) use ($locationId): void {
                $query->whereHasLocation($locationId);
            })
            ->where('location_id', $locationId)
            ->whereBetweenStayTime($dateTime)
            ->where('status_id', setting('confirmed_reservation_status'))
            ->get()
            ->pluck('tables')
            ->flatten()
            ->keyBy('id');
    }

    public static function listCalendarEvents($startAt, $endAt, $locationId = null)
    {
        $query = self::query()->whereBetween('reserve_date', [
            date('Y-m-d H:i:s', strtotime((string)$startAt)),
            date('Y-m-d H:i:s', strtotime((string)$endAt)),
        ]);

        if (!empty($locationId)) {
            $query->whereHasLocation($locationId);
        }

        /** @var Collection<int, Reservation> $collection */
        $collection = $query->get();

        $collection->transform(fn(Reservation $reservation): array => $reservation->getEventDetails());

        return $collection->toArray();
    }

    public function getEventDetails(): array
    {
        $status = $this->status;
        $tables = $this->tables->map(fn($table) => $table->toArray());

        return [
            'id' => $this->getKey(),
            'title' => $this->table_name.' ('.$this->guest_num.')',
            'start' => $this->reservation_datetime->toIso8601String(),
            'end' => $this->reservation_end_datetime->toIso8601String(),
            'allDay' => $this->isReservedAllDay(),
            'color' => $status?->status_color,
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
            'status' => $status?->toArray() ?? [],
            'tables' => $tables->toArray(),
        ];
    }

    public function isReservedAllDay(): bool
    {
        $diffInMinutes = (int)floor($this->reservation_datetime->diffInMinutes($this->reservation_end_datetime));

        return $diffInMinutes >= (60 * 23) || $diffInMinutes === 0;
    }

    public function getOccasionOptions(): array
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

    public function getDiningTableOptions()
    {
        if (!$location = $this->location) {
            return [];
        }

        return DiningTable::query()->whereHasLocation($location)->pluck('name', 'id');
    }

    /**
     * Return the dates of all reservations
     */
    public function getReservationDates()
    {
        return static::pluckDates('reserve_date');
    }

    /**
     * Create new or update existing reservation tables
     *
     * @param array $tableIds if empty all existing records will be deleted
     */
    public function addReservationTables(array $tableIds = []): bool
    {
        if (!$this->exists) {
            return false;
        }

        static::tables()->sync($tableIds);

        return true;
    }

    public static function listFullyBookedTimeslots(
        array $dateTimes,
        int $locationId,
        ?int $noOfGuest = null,
    ): array {
        // Get all available tables for the location
        $totalAvailableTables = DiningTable::query()
            ->whereIsAvailableAt($locationId)
            ->whereIsReservable()
            ->when($noOfGuest, fn($query) => $query->whereCanAccommodate($noOfGuest))
            ->count('dining_tables.id');

        if ($totalAvailableTables === 0) {
            return $dateTimes;
        }

        // Get all tables that are booked during any of the requested timeslots
        $bookedTables = self::query()
            ->join('reservation_tables', 'reservation_tables.reservation_id', '=', 'reservations.reservation_id')
            ->join('dining_tables', 'dining_tables.id', '=', 'reservation_tables.dining_table_id')
            ->select([
                'reservations.reservation_id',
                'reservations.reserve_date',
                'reservations.reserve_time',
                'reservations.duration',
                'dining_tables.id as dining_table_id',
                'dining_tables.min_capacity',
                'dining_tables.max_capacity',
            ])
            ->whereHasLocation($locationId)
            ->whereBetweenReservationDateTime(min($dateTimes), max($dateTimes))
            ->whereNotIn('status_id', [0, (int)setting('canceled_reservation_status')])
            ->where('dining_tables.min_capacity', '<=', $noOfGuest)
            ->where('dining_tables.max_capacity', '>=', $noOfGuest)
            ->get();

        // Find timeslots where all available tables are booked
        return collect($dateTimes)
            ->filter(fn($dateTime): bool => $bookedTables->filter(function($reservation) use ($dateTime): bool {
                $dateTime = make_carbon($dateTime);

                return $dateTime->gte($reservation->reservation_datetime)
                    && $dateTime->lt($reservation->reservation_end_datetime);
            })->unique('dining_table_id')->count() >= $totalAvailableTables,
            )->all();
    }

    public function getNextBookableTable(): Collection
    {
        $diningTables = DiningTable::query()
            ->with(['dining_section'])
            ->withCount(['reservations' => function($query): void {
                $query->where('reserve_date', $this->reserve_date->toDateString())
                    ->whereNotIn('status_id', [0, setting('canceled_reservation_status')]);
            }])
            ->reservable([
                'locationId' => $this->location_id,
                'dateTime' => $this->reservation_datetime,
                'guestNum' => $this->guest_num,
                'duration' => $this->duration,
            ])->get();

        if (!$diningTable = $this->getNextBookableTableInSection($diningTables)) {
            $diningTable = $diningTables->first();
        }

        return collect($diningTable ? [$diningTable] : []);
    }

    public function autoAssignTable(): bool
    {
        $diningTables = $this->getNextBookableTable();
        if ($diningTables->isEmpty()) {
            return false;
        }

        $this->addReservationTables($diningTables->pluck('id')->all());

        return true;
    }

    protected function getLastSectionId()
    {
        /** @var null|Reservation $lastReservation */
        $lastReservation = $this->newQuery()
            ->has('tables')
            ->where('location_id', $this->location_id)
            ->whereDate('reserve_date', $this->reserve_date)
            ->where(function($query): void {
                $query->whereNotIn('status_id', [0, setting('canceled_reservation_status')]);
            })
            ->orderBy('reservation_id', 'desc')
            ->first();

        $nextSectionId = null;
        if ($lastReservation && $lastReservation->tables->first()->dining_section) {
            $nextSectionId = $lastReservation->tables->first()->dining_section->id;
        }

        return $nextSectionId;
    }

    protected function getNextBookableTableInSection($diningTables)
    {
        if ($diningTables->isEmpty() || $diningTables->pluck('dining_section.id')->unique()->isEmpty()) {
            return null;
        }

        $diningSectionsIds = DiningSection::query()->whereHasLocation($this->location_id)
            ->whereIsReservable()->orderBy('priority')->pluck('id');

        if ($diningSectionsIds->isEmpty()) {
            return null;
        }

        $diningSectionsIds = $diningSectionsIds->all();

        $lastSectionId = $this->getLastSectionId();
        if (($nextIndex = array_search($lastSectionId, $diningSectionsIds, true)) !== false) {
            $nextIndex++;
        }

        $sectionCount = count($diningSectionsIds);
        if ($nextIndex === false || $nextIndex >= $sectionCount) {
            $nextIndex = 0;
        }

        $diningTable = null;
        $diningSections = $diningTables->groupBy('dining_section.id')->all();
        for ($i = $nextIndex; $i < $sectionCount; $i++) {
            $sectionId = $diningSectionsIds[$i];
            $tables = array_pull($diningSections, $sectionId);
            if ($tables && $tables->isNotEmpty()) {
                $diningTable = $tables->sortBy('reservations_count')->first();
                break;
            }
        }

        return $diningTable;
    }

    //
    // Mail
    //

    public function mailGetRecipients($type): array
    {
        $emailSetting = setting('reservation_email', []);
        if (!is_array($emailSetting)) {
            $emailSetting = [];
        }

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

    public function mailGetReplyTo($type): array
    {
        $replyTo = [];
        if (in_array($type, (array)setting('reservation_email', []))) {
            switch ($type) {
                case 'location':
                    $replyTo = [$this->location->location_email, $this->location->location_name];
                    break;
                case 'admin':
                    $replyTo = [setting('site_email'), setting('site_name')];
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

        /** @var StatusHistory|null $statusHistory */
        $statusHistory = StatusHistory::applyRelated($model)->whereStatusIsLatest($model->status_id)->first();
        $data['status_name'] = $statusHistory?->status?->status_name;
        $data['status_comment'] = $statusHistory?->comment;

        $controller = MainController::getController();
        $data['reservation_view_url'] = $controller->pageUrl('account.reservations', [
            'reservationId' => $model->reservation_id,
        ]);

        return $data;
    }
}
