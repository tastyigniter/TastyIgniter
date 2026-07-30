<?php

declare(strict_types=1);

namespace Igniter\Local\Classes;

use Igniter\Local\Models\WorkingHour;

class ScheduleItem
{
    public string $type;

    public array $days;

    public string $open;

    public string $close;

    public array $timesheet;

    public array $flexible;

    /**
     * @var array
     */
    protected $data;

    public function __construct(public string $name) {}

    public static function create(string $name, array $data = []): self
    {
        $instance = resolve(static::class, ['name' => $name]);
        $instance->data = $data;
        $instance->type = array_get($data, 'type', '24_7');
        $instance->days = array_get($data, 'days') ?: range(0, 6);
        $instance->open = array_get($data, 'open', '00:00');
        $instance->close = array_get($data, 'close', '23:59');
        $instance->timesheet = $instance->timesheet(array_get($data, 'timesheet', []));
        $instance->flexible = $instance->flexible(array_get($data, 'flexible', []));

        return $instance;
    }

    public function getHours(): array
    {
        $result = [];

        for ($day = 0; $day <= 6; $day++) {
            $result[] = match ($this->type) {
                '24_7' => [[
                    'day' => $day,
                    'open' => '00:00',
                    'close' => '23:59',
                    'status' => true,
                ]],
                'daily' => [[
                    'day' => $day,
                    'open' => $this->open,
                    'close' => $this->close,
                    'status' => in_array($day, $this->days),
                ]],
                'timesheet' => $this->createHours($day, $this->timesheet[$day]),
                'flexible' => $this->createHours($day, $this->flexible[$day]),
                default => [],
            };
        }

        return $result;
    }

    public function getFormatted(): array
    {
        $result = [];

        $hours = $this->getHours();
        foreach ((new WorkingHour)->getWeekDaysOptions() as $index => $day) {
            $formattedHours = [];
            foreach (array_get($hours, $index, []) as $hour) {
                if (!$hour['status']) {
                    continue;
                }

                $formattedHours[] = sprintf('%s-%s', $hour['open'], $hour['close']);
            }

            $result[] = (object)[
                'day' => $day,
                'hours' => $formattedHours !== [] ? implode(', ', $formattedHours) : '--',
            ];
        }

        return $result;
    }

    protected function timesheet($timesheet): array
    {
        if (is_string($timesheet)) {
            $timesheet = @json_decode($timesheet, true) ?: [];
        }

        $result = [];
        foreach (WorkingHour::$weekDays as $key => $weekDay) {
            $result[$key] = array_get($timesheet, $key, [
                'day' => $key,
                'hours' => [['open' => '00:00', 'close' => '23:59']],
                'status' => true,
            ]);
        }

        return $result;
    }

    protected function flexible(array $data): array
    {
        $result = [];
        foreach (WorkingHour::$weekDays as $key => $weekDay) {
            $hour = array_get($data, $key, []);
            if (isset($hour['open'], $hour['close'])) {
                $hour['hours'] = sprintf('%s-%s', $hour['open'], $hour['close']);
                unset($hour['open'], $hour['close']);
            }

            $result[$key] = [
                'day' => $hour['day'] ?? $key,
                'hours' => $hour['hours'] ?? '00:00-23:59',
                'status' => (bool)($hour['status'] ?? 1),
            ];
        }

        return $result;
    }

    protected function createHours(int $day, array $data): array
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
                'status' => (bool)($data['status'] ?? 1),
            ];
        }

        return $result;
    }
}
