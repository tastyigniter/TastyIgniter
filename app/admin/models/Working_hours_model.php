<?php namespace Admin\Models;

use Carbon\Carbon;
use Model;

/**
 * Working hours Model Class
 *
 * @package Admin
 */
class Working_hours_model extends Model
{
	/**
	 * @var string The database table name
	 */
	protected $table = 'working_hours';

    protected $primaryKey = 'location_id';

    public $incrementing = false;

    public $fillable = ['location_id', 'weekday', 'opening_time', 'closing_time', 'status', 'type'];

    public $relation = [
        'belongsTo' => [
            'location' => ['Admin\Models\Locations_model']
        ]
    ];

    protected $appends = ['day', 'weekDate', 'open', 'close', 'past_midnight', 'open_all_day'];

    protected $timeFormat = 'H:i';

    public $casts = [
        'opening_time' => 'time',
        'closing_time' => 'time',
    ];

    protected static $weekDays = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];

    public function getDayAttribute()
    {
        return self::$weekDays[$this->weekday];
    }

    public function getOpenAllDayAttribute()
    {
        if (!$this->opening_time OR !$this->closing_time)
            return null;

        $diffInHours = $this->opening_time->diffInHours($this->close);
        return $diffInHours >= 23 OR $diffInHours == 0;
    }

    public function getOpenAttribute()
    {
        $open = "{$this->weekDate} {$this->attributes['opening_time']}";

        return Carbon::createFromFormat('Y-m-d H:i:s', $open);
	}

    public function getCloseAttribute()
    {
        $open = "{$this->weekDate} {$this->attributes['closing_time']}";

        $date = Carbon::createFromFormat('Y-m-d H:i:s', $open);

        if ($this->opening_time->gt($this->closing_time))
            $date->addDay();

        return $date;
	}

    public function getWeekDateAttribute()
    {
        return isset($this->attributes['weekDate']) ? $this->attributes['weekDate'] : mdate('%Y-%m-%d', time());
	}

    public function getPastMidnightAttribute()
    {
        if (!$this->open OR !$this->close)
            return null;

        return $this->open->gt($this->close);
	}

    public function getHoursByLocation($id)
    {
        $collection = [];

        foreach ($this->where('location_id', $id)->get() as $row) {
            $row = $this->parseRecord($row);
            $collection[$row['type']][$row['weekday']] = $this->parseRecord($row);
        }

        return $collection;
    }

    public function lastOrderTime()
    {
        $lastOrderTime = !empty($this->location->last_order_time) ? $this->location->last_order_time : 0;

        return $lastOrderTime * 60;
    }

    public function setWeekDate($time)
    {
        $this->attributes['weekDate'] = mdate('%Y-%m-%d', strtotime($time));

        return $this;
	}

	public function setWeekDays($weekDays)
	{
		$this->weekDays = $weekDays;
	}

	public function getWeekDays()
	{
		return $this->weekDays;
	}

    public function parseRecord($row)
    {
        $type = !empty($row['type']) ? $row['type'] : 'opening';
        $collection = array_merge($row, [
            'location_id' => $row['location_id'],
            'day'         => $row['day'],
            'type'        => $type,
            'open'        => strtotime("{$row['day']} {$row['opening_time']}"),
            'close'       => strtotime("{$row['day']} {$row['closing_time']}"),
            'is_24_hours' => $row['open_all_day'],
        ]);

        return $collection;
    }
}