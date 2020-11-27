<?php

namespace Admin\Traits;

use Admin\Classes\ScheduleItem;
use Carbon\Carbon;
use Exception;
use Igniter\Flame\Location\WorkingSchedule;
use Illuminate\Support\Collection;
use InvalidArgumentException;

trait HasWorkingHours
{
    /**
     * @var \Illuminate\Database\Eloquent\Collection
     */
    protected $workingHours;

    protected $currentTime;

    public static function bootHasWorkingHours()
    {
        static::fetched(function (self $model) {
            $value = @unserialize($model->attributes['options']) ?: [];

            $model->parseHoursFromOptions($value);

            $model->attributes['options'] = @serialize($value);
        });

        static::saving(function (self $model) {
            $value = @unserialize($model->attributes['options']) ?: [];

            $model->parseHoursFromOptions($value);

            $model->attributes['options'] = @serialize($value);
        });
    }

    /**
     * @return Carbon
     */
    public function getCurrentTime()
    {
        if (!is_null($this->currentTime))
            return $this->currentTime;

        return $this->currentTime = Carbon::now();
    }

    public function availableWorkingTypes()
    {
        return [static::OPENING, static::DELIVERY, static::COLLECTION];
    }

    public function listWorkingHours()
    {
        if (!$this->workingHours)
            $this->workingHours = $this->loadWorkingHours();

        return $this->workingHours;
    }

    /**
     * @param null $hourType
     *
     * @return mixed 24_7, daily or flexible
     */
    public function workingHourType($hourType = null)
    {
        return array_get($this->options, "hours.{$hourType}.type");
    }

    public function getWorkingHoursByType($type)
    {
        if (!$workingHours = $this->listWorkingHours())
            return null;

        return $workingHours->groupBy('type')->get($type);
    }

    public function getWorkingHoursByDay($weekday)
    {
        if (!$workingHours = $this->listWorkingHours())
            return null;

        return $workingHours->groupBy('weekday')->get($weekday);
    }

    public function getWorkingHourByDayAndType($weekday, $type)
    {
        if (!$workingHours = $this->getWorkingHoursByDay($weekday))
            return null;

        return $workingHours->groupBy('type')->get($type)->first();
    }

    public function getWorkingHourByDateAndType($date, $type)
    {
        if (!$date instanceof Carbon)
            $date = make_carbon($date);

        $weekday = $date->format('N') - 1;

        return $this->getWorkingHourByDayAndType($weekday, $type);
    }

    public function loadWorkingHours()
    {
        if (!$this->hasRelation('working_hours'))
            throw new Exception(sprintf("Model '%s' does not contain a definition for 'working_hours'.",
                get_class($this)));

        return $this->working_hours()->get();
    }

    public function newWorkingSchedule($type, $days = null)
    {
        $types = $this->availableWorkingTypes();
        if (is_null($type) OR !in_array($type, $types))
            throw new InvalidArgumentException("Defined parameter '$type' is not a valid working type.");

        if (is_null($days)) {
            $days = $this->hasFutureOrder($type)
                ? (int)$this->futureOrderDays($type)
                : 0;
        }

        $schedule = WorkingSchedule::create($days,
            $this->getWorkingHoursByType($type) ?? new Collection([])
        );

        $schedule->setType($type);
        $schedule->setNow($this->getCurrentTime());

        return $schedule;
    }

    //
    //
    //

    public function createScheduleItem($type)
    {
        if (is_null($type) OR !in_array($type, $this->availableWorkingTypes()))
            throw new InvalidArgumentException("Defined parameter '$type' is not a valid working type.");

        $scheduleData = array_get($this->getOption('hours', []), $type, []);

        return new ScheduleItem($type, $scheduleData);
    }

    public function updateSchedule($type, $scheduleData)
    {
        $this->addOpeningHours($type, $scheduleData);

        $locationHours = $this->getOption('hours');
        array_set($locationHours, $type, $scheduleData);
        $this->setOption('hours', $locationHours);

        $this->save();
    }

    /**
     * Create a new or update existing location working hours
     *
     * @param array $data
     *
     * @return bool
     */
    public function addOpeningHours($type, $data = [])
    {
        if (is_array($type)) {
            $data = $type;
            $type = null;
        }

        if (is_null($type)) {
            foreach (['opening', 'delivery', 'collection'] as $type) {
                if (!is_array($scheduleData = array_get($data, $type)))
                    continue;

                $this->addOpeningHours($type, $scheduleData);
            }
        }

        $this->working_hours()->where('type', $type)->delete();

        $scheduleItem = new ScheduleItem($type, $data);
        foreach ($scheduleItem->getHours() as $day => $hours) {
            foreach ($hours as $hour) {
                $this->working_hours()->create([
                    'location_id' => $this->getKey(),
                    'weekday' => $hour['day'],
                    'type' => $type,
                    'opening_time' => mdate('%H:%i', strtotime($hour['open'])),
                    'closing_time' => mdate('%H:%i', strtotime($hour['close'])),
                    'status' => $hour['status'],
                ]);
            }
        }

        return TRUE;
    }

    protected function parseHoursFromOptions(&$value)
    {
        // Rename options array index 'opening_hours' to 'hours'
        if (isset($value['opening_hours'])) {
            $hours = $value['opening_hours'];
            foreach (['opening', 'daily', 'delivery', 'collection'] as $type) {
                foreach (['type', 'days', 'hours'] as $suffix) {
                    if (isset($hours["{$type}_{$suffix}"])) {
                        $valueItem = $hours["{$type}_{$suffix}"];
                        if ($suffix == 'type')
                            $valueItem = $valueItem != '24_7' ? $valueItem : '24_7';

                        $typeIndex = $type == 'daily' ? 'opening' : $type;

                        if ($suffix == 'hours') {
                            $value['hours'][$typeIndex]['open'] = $valueItem['open'] ?? '00:00';
                            $value['hours'][$typeIndex]['close'] = $valueItem['close'] ?? '23:59';
                        }
                        else {
                            $value['hours'][$typeIndex][$suffix] = $valueItem;
                        }
                    }
                }
            }

            if (isset($hours['flexible_hours']) AND is_array($hours['flexible_hours'])) {
                foreach (['opening', 'delivery', 'collection'] as $type) {
                    $value['hours'][$type]['flexible'] = $hours['flexible_hours'];
                }
            }

            unset($value['opening_hours']);
        }
    }
}
