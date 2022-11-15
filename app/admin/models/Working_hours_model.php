<?php

namespace Admin\Models;

use Igniter\Flame\Location\Models\AbstractWorkingHour;

/**
 * Working hours Model Class
 */
class Working_hours_model extends AbstractWorkingHour
{
    protected $primaryKey = 'id';

    public $fillable = ['location_id', 'weekday', 'opening_time', 'closing_time', 'status', 'type'];

    protected $casts = [
        'weekday' => 'integer',
        'opening_time' => 'time',
        'closing_time' => 'time',
        'status' => 'boolean',
    ];

    public static $weekDays = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];

    public function getHoursByLocation($id)
    {
        $collection = [];

        foreach (self::where('location_id', $id)->get() as $row) {
            $row = $this->parseRecord($row);
            $collection[$row['type']][$row['weekday']] = $row;
        }

        return $collection;
    }

    public function parseRecord($row)
    {
        $type = !empty($row['type']) ? $row['type'] : 'opening';
        $collection = array_merge($row, [
            'location_id' => $row['location_id'],
            'day' => $row['day'],
            'type' => $type,
            'open' => strtotime("{$row['day']} {$row['opening_time']}"),
            'close' => strtotime("{$row['day']} {$row['closing_time']}"),
            'is_24_hours' => $row['open_all_day'],
        ]);

        return $collection;
    }

    public function getWeekDaysOptions()
    {
        return collect(self::$weekDays)->map(function ($day, $index) {
            return now()->startOfWeek()->addDays($index)->isoFormat(lang('system::lang.moment.weekday_format'));
        })->all();
    }

    public function getTimesheetOptions($value, $data)
    {
        $result = new \stdClass();
        $result->timesheet = $value ?? [];

        $result->daysOfWeek = [];
        foreach ($this->getWeekDaysOptions() as $key => $day) {
            $result->daysOfWeek[$key] = ['name' => $day];
        }

        return $result;
    }
}
