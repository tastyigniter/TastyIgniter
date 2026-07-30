<?php

declare(strict_types=1);

namespace Igniter\Local\Models\Concerns;

use Carbon\Carbon;
use Igniter\Cart\Classes\OrderTypes;
use Igniter\Local\Classes\ScheduleItem;
use Igniter\Local\Classes\WorkingSchedule;
use Igniter\Local\Events\WorkingScheduleCreatedEvent;
use Igniter\Local\Exceptions\WorkingHourException;
use Illuminate\Database\Eloquent\RelationNotFoundException;
use Illuminate\Support\Collection;
use InvalidArgumentException;

trait HasWorkingHours
{
    public function availableWorkingTypes(): array
    {
        return array_merge([
            static::OPENING,
        ], collect(resolve(OrderTypes::class)->listOrderTypes())->keys()->all());
    }

    /**
     * @return mixed 24_7, daily or flexible
     */
    public function workingHourType($hourType = null)
    {
        return $this->getSettings(sprintf('hours.%s.type', $hourType));
    }

    public function getWorkingHoursByType($type)
    {
        return $this->getWorkingHours()->groupBy('type')->get($type);
    }

    public function getWorkingHoursByDay($weekday)
    {
        return $this->getWorkingHours()->groupBy('weekday')->get($weekday);
    }

    public function getWorkingHourByDayAndType($weekday, $type)
    {
        return $this->getWorkingHoursByDay($weekday)
            ->groupBy('type')
            ->get($type)
            ->first();
    }

    public function getWorkingHourByDateAndType($date, $type)
    {
        if (!$date instanceof Carbon) {
            $date = make_carbon($date);
        }

        return $this->getWorkingHourByDayAndType($date->format('N'), $type);
    }

    public function getWorkingHours()
    {
        if (!$this->hasRelation('working_hours')) {
            throw RelationNotFoundException::make($this, 'working_hours');
        }

        if (!$this->working_hours || $this->working_hours->isEmpty()) {
            $this->createDefaultWorkingHours();
        }

        return $this->working_hours;
    }

    public function newWorkingSchedule($type, $days = null)
    {
        $types = $this->availableWorkingTypes();
        if (is_null($type) || !in_array($type, $types)) {
            throw new WorkingHourException(sprintf(lang('igniter.local::default.alert_invalid_schedule_type'), $type));
        }

        if (is_null($days)) {
            $days = $this->hasFutureOrder($type) ? (int)$this->futureOrderDays($type) : 0;
        }

        $schedule = WorkingSchedule::create($days,
            $this->getWorkingHoursByType($type) ?? new Collection([]),
        );

        $schedule->setType($type);

        WorkingScheduleCreatedEvent::dispatch($this, $schedule);

        return $schedule;
    }

    //
    //
    //

    public function createScheduleItem(string $type, ?array $scheduleData = null): ScheduleItem
    {
        if (!in_array($type, $this->availableWorkingTypes())) {
            throw new InvalidArgumentException(sprintf(lang('igniter.local::default.alert_invalid_schedule_type'), $type));
        }

        $scheduleData = $scheduleData ?: array_get($this->getSettings('hours', []), $type, []);

        return ScheduleItem::create($type, $scheduleData);
    }

    public function updateSchedule($type, $scheduleData): void
    {
        $this->addOpeningHours($type, $scheduleData);

        $locationHours = $this->findSettings('hours');
        $locationHours->fill([$type => $scheduleData])->save();
    }

    /**
     * Create a new or update existing location working hours
     */
    public function addOpeningHours(null|string|array $type, ?array $data = []): bool
    {
        if (is_array($type)) {
            $data = $type;
            $type = null;
        }

        if (is_null($type)) {
            foreach (['opening', 'delivery', 'collection'] as $hourType) {
                if (!is_array($scheduleData = array_get($data, $hourType))) {
                    continue;
                }

                $this->addOpeningHours($hourType, $scheduleData);
            }

            return true;
        }

        $this->working_hours()->where('type', $type)->delete();

        $scheduleItem = $this->createScheduleItem($type, $data);
        foreach ($scheduleItem->getHours() as $hours) {
            foreach ($hours as $hour) {
                $this->working_hours()->create([
                    'location_id' => $this->getKey(),
                    'weekday' => $hour['day'],
                    'type' => $type,
                    'opening_time' => mdate('%H:%i', strtotime((string)$hour['open'])),
                    'closing_time' => mdate('%H:%i', strtotime((string)$hour['close'])),
                    'status' => $hour['status'],
                ]);
            }
        }

        return true;
    }

    protected function createDefaultWorkingHours()
    {
        foreach (['opening', 'delivery', 'collection'] as $hourType) {
            $this->addOpeningHours($hourType);
        }

        $this->reloadRelations('working_hours');
    }
}
