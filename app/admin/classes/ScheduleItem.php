<?php

namespace Admin\Classes;

use Admin\Models\Working_hours_model;

class ScheduleItem
{
    public $name;

    public $type;

    public $days;

    public $open;

    public $close;

    public $timesheet;

    public $flexible;

    /**
     * @var array
     */
    protected $data;

    public function __construct($name, array $data = [])
    {
        $this->name = $name;
        $this->type = array_get($data, 'type', '24_7');
        $this->days = array_get($data, 'days') ?: [];
        $this->open = array_get($data, 'open', '00:00');
        $this->close = array_get($data, 'close', '23:59');
        $this->timesheet = $this->timesheet(array_get($data, 'timesheet', []));
        $this->flexible = $this->flexible(array_get($data, 'flexible', []));

        $this->data = $data;
    }

    public function getHours()
    {
        $result = [];

        for ($day = 0; $day <= 6; $day++) {
            if ($this->type == '24_7') {
                $result[] = [['day' => $day, 'open' => '00:00', 'close' => '23:59', 'status' => 1]];
            }
            elseif ($this->type == 'daily') {
                $result[] = [[
                    'day' => $day,
                    'open' => $this->open,
                    'close' => $this->close,
                    'status' => (int)in_array($day, $this->days),
                ]];
            }
            elseif ($this->type == 'timesheet') {
                $result[] = $this->createHours($day, $this->timesheet[$day]);
            }
            elseif ($this->type == 'flexible') {
                $result[] = $this->createHours($day, $this->flexible[$day]);
            }
        }

        return $result;
    }

    public function getFormatted()
    {
        $result = [];

        $hours = $this->getHours();
        foreach (Working_hours_model::make()->getWeekDaysOptions() as $index => $day) {
            $formattedHours = [];
            foreach (array_get($hours, $index, []) as $hour) {
                if (!$hour['status'])
                    continue;

                $formattedHours[] = sprintf('%s-%s', $hour['open'], $hour['close']);
            }

            $result[] = (object)[
                'day' => $day,
                'hours' => $formattedHours ? implode(', ', $formattedHours) : '--',
            ];
        }

        return $result;
    }

    protected function timesheet($timesheet)
    {
        if (is_string($timesheet))
            $timesheet = @json_decode($timesheet, true) ?: [];

        $result = [];
        foreach (Working_hours_model::$weekDays as $key => $weekDay) {
            $result[$key] = array_get($timesheet, $key, [
                'day' => $key,
                'hours' => [['open' => '00:00', 'close' => '23:59']],
                'status' => true,
            ]);
        }

        return $result;
    }

    protected function flexible(array $data)
    {
        $result = [];
        foreach (Working_hours_model::$weekDays as $key => $weekDay) {
            $hour = array_get($data, $key, []);
            if (isset($hour['open']) && isset($hour['close'])) {
                $hour['hours'] = sprintf('%s-%s', $hour['open'], $hour['close']);
                unset($hour['open'], $hour['close']);
            }

            $result[$key] = [
                'day' => $hour['day'] ?? $key,
                'hours' => $hour['hours'] ?? '00:00-23:59',
                'status' => $hour['status'] ?? 1,
            ];
        }

        return $result;
    }

    protected function createHours(int $day, $data): array
    {
        $result = [];

        $hours = is_string($data['hours'])
            ? explode(',', $data['hours'])
            : $data['hours'];

        foreach ($hours as $hour) {
            $hour = is_string($hour) ? explode('-', $hour) : $hour;
            $result[] = [
                'day' => $day,
                'open' => array_get($hour, 0, array_get($hour, 'open')),
                'close' => array_get($hour, 1, array_get($hour, 'close')),
                'status' => $data['status'],
            ];
        }

        return $result;
    }
}
