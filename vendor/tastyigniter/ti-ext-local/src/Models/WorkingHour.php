<?php

declare(strict_types=1);

namespace Igniter\Local\Models;

use Carbon\Carbon;
use Igniter\Flame\Database\Model;
use Igniter\Local\Contracts\WorkingHourInterface;
use Igniter\System\Models\Concerns\Switchable;
use Override;
use stdClass;

/**
 * Working hours Model Class
 *
 * @property int $location_id
 * @property int $weekday
 * @property mixed $opening_time
 * @property mixed $closing_time
 * @property bool $status
 * @property string $type
 * @property int $id
 * @property-read mixed $close
 * @property-read mixed $day
 * @property-read mixed $open
 * @mixin Model
 */
class WorkingHour extends Model implements WorkingHourInterface
{
    use Switchable;

    const CLOSED = 'closed';

    const OPEN = 'open';

    const OPENING = 'opening';

    /**
     * @var string The database table name
     */
    protected $table = 'working_hours';

    protected $timeFormat = 'H:i';

    public $relation = [
        'belongsTo' => [
            'location' => [Location::class],
        ],
    ];

    protected $appends = ['day', 'open', 'close'];

    public $attributes = [
        'opening_time' => '00:00',
        'closing_time' => '23:59',
    ];

    protected $casts = [
        'weekday' => 'integer',
        'opening_time' => 'time',
        'closing_time' => 'time',
    ];

    public static $weekDays = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];

    public function getWeekDaysOptions()
    {
        return collect(self::$weekDays)->map(fn($day, $index) => now()->startOfWeek()->addDays($index)->isoFormat(lang('igniter::system.moment.weekday_format')))->all();
    }

    public function getTimesheetOptions($value, $data): stdClass
    {
        $result = new stdClass;
        $result->timesheet = $value ?? [];

        $result->daysOfWeek = [];
        foreach ($this->getWeekDaysOptions() as $key => $day) {
            $result->daysOfWeek[$key] = ['name' => $day];
        }

        return $result;
    }

    //
    // Accessors & Mutators
    //

    public function getDayAttribute()
    {
        return Carbon::now()->startOfWeek()->addDays($this->weekday);
    }

    public function getOpenAttribute()
    {
        $openDate = $this->getWeekDate();

        $openDate->setTimeFromTimeString($this->opening_time);

        return $openDate;
    }

    public function getCloseAttribute()
    {
        $closeDate = $this->getWeekDate();

        $closeDate->setTimeFromTimeString($this->closing_time);

        if ($this->isPastMidnight()) {
            $closeDate->addDay();
        }

        return $closeDate;
    }

    //
    // Helpers
    //

    public function isOpenAllDay(): bool
    {
        $diffInHours = (int)floor($this->open->diffInHours($this->close));

        return $diffInHours >= 23 || $diffInHours === 0;
    }

    public function isPastMidnight(): bool
    {
        return $this->opening_time > $this->closing_time;
    }

    #[Override]
    public function getDay()
    {
        return $this->day->format('l');
    }

    #[Override]
    public function getOpen()
    {
        return $this->open->format('H:i');
    }

    #[Override]
    public function getClose()
    {
        return $this->close->format('H:i');
    }

    public function getWeekDate(): Carbon
    {
        return new Carbon($this->day);
    }
}
