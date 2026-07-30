<?php

declare(strict_types=1);

namespace Igniter\Local\Classes;

use Carbon\Carbon;
use DateInterval;
use DatePeriod;
use DateTime;
use DateTimeImmutable;
use DateTimeInterface;
use DateTimeZone;
use Igniter\Local\Contracts\WorkingHourInterface;
use Igniter\Local\Events\WorkingScheduleTimeslotValidEvent;
use Igniter\Local\Exceptions\WorkingHourException;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class WorkingSchedule
{
    protected ?string $type = null;

    protected ?DateTimeZone $timezone;

    /**
     * @var WorkingPeriod[] Holds working periods
     */
    protected array $periods;

    /**
     * @var WorkingPeriod[] Holds working periods exceptions
     */
    protected $exceptions = [];

    protected int $minDays = 0;

    protected int $maxDays = 0;

    public function __construct(?string $timezone = null, int|array $days = 5)
    {
        $this->timezone = $timezone ? new DateTimeZone($timezone) : null;
        [$this->minDays, $this->maxDays] = is_array($days) ? $days : [0, $days];

        $this->periods = WorkingDay::mapDays(fn(): WorkingPeriod => new WorkingPeriod);
    }

    /**
     * $periods = [
     *    [
     *      'day' => 'monday',
     *      'open' => '09:00',
     *      'close' => '12:00'
     *    ],
     *    [
     *      'day' => 'monday',
     *      'open' => '09:00',
     *      'close' => '12:00'
     *    ],
     *    'wednesday' => [
     *      ['09:00', '12:00'],
     *      ['09:00', '12:00']
     *    ]
     * ];
     */
    public static function create(int|array $days, array|Collection $periods, $exceptions = []): static
    {
        return (new static(null, $days))->fill([
            'periods' => $periods,
            'exceptions' => $exceptions,
        ]);
    }

    public function fill(array $data): static
    {
        $exceptions = Arr::get($data, 'exceptions', []);
        $periods = $this->parsePeriods(Arr::get($data, 'periods', []));

        $this->setPeriods($periods);
        $this->setExceptions($exceptions);

        return $this;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function setNow(DateTime $now): static
    {
        traceLog('Deprecated function. No longer supported.');

        return $this;
    }

    public function setTimezone(string $timezone): void
    {
        $this->timezone = new DateTimeZone($timezone);
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function minDays(): int
    {
        return $this->minDays;
    }

    public function days(): int
    {
        return $this->maxDays;
    }

    public function exceptions(): array
    {
        return $this->exceptions;
    }

    //
    //
    //
    /**
     * @throws WorkingHourException
     */
    public function forDay(string $day): WorkingPeriod
    {
        $day = WorkingDay::normalizeName($day);

        return $this->periods[$day];
    }

    public function forDate(DateTimeInterface $date): WorkingPeriod
    {
        $date = $this->applyTimezone($date);

        return $this->exceptions[$date->format('Y-m-d')]
            ?? ($this->exceptions[$date->format('m-d')]
                ?? $this->forDay(WorkingDay::onDateTime($date)));
    }

    public function isOpen(): bool
    {
        return $this->isOpenAt(Carbon::now());
    }

    public function isOpening(): bool
    {
        return (bool)$this->nextOpenAt(Carbon::now());
    }

    public function isClosed(): bool
    {
        return $this->isClosedAt(Carbon::now());
    }

    public function isOpenOn(string $day): bool
    {
        return count($this->forDay($day)) > 0;
    }

    public function isClosedOn(string $day): bool
    {
        return !$this->isOpenOn($day);
    }

    public function isOpenAt(DateTimeInterface $dateTime): bool
    {
        $workingTime = WorkingTime::fromDateTime($dateTime);

        if ($this->forDate($dateTime)->isOpenAt($workingTime)) {
            return true;
        }

        // Cover the edge case where we have late night opening,
        // but are closed the next day and the date range falls
        // inside the late night opening
        return $this->forDate(
            Carbon::parse($dateTime)->subDay(),
        )->opensLateAt($workingTime);
    }

    public function isClosedAt(DateTimeInterface $dateTime): bool
    {
        return !$this->isOpenAt($dateTime);
    }

    public function nextOpenAt(DateTimeInterface $dateTime): ?DateTimeInterface
    {
        if (!$dateTime instanceof DateTimeImmutable) {
            $dateTime = clone $dateTime;
        }

        $nextOpenAt = $this->forDate($dateTime)->nextOpenAt(
            WorkingTime::fromDateTime($dateTime),
        );

        if (!$this->hasPeriod()) {
            return null;
        }

        $days = 0;
        while ($nextOpenAt === false) {
            if ($days >= $this->maxDays) {
                return null;
            }

            $dateTime = $dateTime->modify('+1 day')->setTime(0, 0);
            $workingTime = WorkingTime::fromDateTime($dateTime);

            $forDate = $this->forDate($dateTime);
            $nextOpenAt = $forDate->isEmpty() ? false : $forDate->nextOpenAt($workingTime);

            $days++;
        }

        return $dateTime->setTime(
            (int)$nextOpenAt->toDateTime()->format('G'),
            (int)$nextOpenAt->toDateTime()->format('i'),
        );
    }

    /**
     * Returns the next closed time.
     */
    public function nextCloseAt(DateTimeInterface $dateTime): ?DateTimeInterface
    {
        if (!$dateTime instanceof DateTimeImmutable) {
            $dateTime = clone $dateTime;
        }

        if (!$this->hasPeriod()) {
            return null;
        }

        $forDate = $this->forDate($dateTime);
        $nextCloseAt = $forDate->isEmpty()
            ? false
            : $forDate->nextCloseAt(WorkingTime::fromDateTime($dateTime));

        while ($nextCloseAt === false) {
            $dateTime = $dateTime->modify('+1 day')->setTime(0, 0);
            $workingTime = WorkingTime::fromDateTime($dateTime);

            $forDate = $this->forDate($dateTime);
            $nextCloseAt = $forDate->isEmpty()
                ? false
                : $forDate->nextCloseAt($workingTime);
        }

        return $dateTime->setTime(
            (int)$nextCloseAt->toDateTime()->format('G'),
            (int)$nextCloseAt->toDateTime()->format('i'),
        );
    }

    public function getPeriod(?DateTimeInterface $dateTime = null): WorkingPeriod
    {
        return $this->forDate($this->parseDate($dateTime));
    }

    public function getPeriods(): array
    {
        return $this->periods;
    }

    public function getOpenTime(?string $format = null): null|string|DateTimeInterface
    {
        $time = $this->nextOpenAt(Carbon::now());

        return ($time && $format) ? $time->format($format) : $time;
    }

    public function getCloseTime(?string $format = null): null|string|DateTimeInterface
    {
        $time = $this->nextCloseAt(Carbon::now());

        return ($time && $format) ? $time->format($format) : $time;
    }

    public function checkStatus(null|int|string|DateTime $dateTime = null): string
    {
        $dateTime = $this->parseDate($dateTime);

        if ($this->isOpenAt($dateTime)) {
            return WorkingPeriod::OPEN;
        }

        if ($this->nextOpenAt($dateTime) instanceof DateTimeInterface) {
            return WorkingPeriod::OPENING;
        }

        return WorkingPeriod::CLOSED;
    }

    public function getTimeslot(int $interval = 15, ?DateTime $dateTime = null, int $leadTimeMinutes = 25): Collection
    {
        $dateTime = Carbon::instance($this->parseDate($dateTime));
        $interval = new DateInterval('PT'.($interval ?: 15).'M');
        $leadTime = new DateInterval('PT'.$leadTimeMinutes.'M');

        $timeslots = [];
        $datePeriod = $this->createPeriodForDays($dateTime);

        foreach ($datePeriod ?: [] as $date) {
            $dateString = Carbon::instance($date)->toDateString();

            $periodTimeslot = $this->forDate($date)
                ->timeslot($date, $interval, $leadTime)
                ->filter(fn(DateTimeInterface $timeslot): bool => $this->isTimeslotValid($timeslot, $dateTime, $leadTimeMinutes))
                ->mapWithKeys(fn($timeslot): array => [$timeslot->getTimestamp() => $timeslot]);

            if ($periodTimeslot->isEmpty()) {
                continue;
            }

            $timeslots[$dateString] = $periodTimeslot->all();
        }

        return collect($timeslots);
    }

    public function generateTimeslot(DateTime $date, DateInterval $interval, ?DateInterval $leadTime = null): Collection
    {
        if (is_null($leadTime)) {
            $leadTime = $interval;
        }

        return $this->forDate($date)
            ->timeslot($date, $interval, $leadTime)
            ->filter(function(DateTimeInterface $timeslot) use ($date, $leadTime): bool {
                $dateTime = make_carbon($date)->setTimeFromTimeString($timeslot->format('H:i'));

                return $this->isTimeslotValid($timeslot, $dateTime, $leadTime->i);
            })
            ->mapWithKeys(fn($timeslot): array => [$timeslot->getTimestamp() => $timeslot]);
    }

    public function setPeriods(array $periods): void
    {
        foreach ($periods as $day => $period) {
            $this->periods[$day] = WorkingPeriod::create($period);
        }
    }

    public function setExceptions(array $exceptions): void
    {
        foreach ($exceptions as $day => $exception) {
            $this->exceptions[$day] = WorkingPeriod::create($exception);
        }
    }

    protected function parseDate(null|string|DateTimeInterface $start = null): Carbon
    {
        if ($start === null) {
            return Carbon::now();
        }

        return Carbon::parse($start);
    }

    protected function parsePeriods(array|Collection $periods): array
    {
        $parsedPeriods = [];
        foreach ($periods as $day => $period) {
            if ($period instanceof WorkingHourInterface) {
                if (!$period->isEnabled()) {
                    continue;
                }

                $day = WorkingDay::normalizeName($period->getDay());
                $parsedPeriods[$day][] = [
                    $period->getOpen(),
                    $period->getClose(),
                ];
            } elseif (is_array($period)) {
                $day = WorkingDay::normalizeName($day);
                $parsedPeriods[$day] = array_merge(
                    $parsedPeriods[$day] ?? [], $period,
                );
            }
        }

        return $parsedPeriods;
    }

    protected function applyTimezone(DateTimeInterface $date): DateTimeInterface
    {
        if ($this->timezone && method_exists($date, 'setTimezone')) {
            $date = $date->setTimezone($this->timezone);
        }

        return $date;
    }

    protected function isTimeslotValid(DateTimeInterface $timeslot, DateTimeInterface $dateTime, int $leadTimeMinutes): bool
    {
        if (Carbon::instance($dateTime)->gt($timeslot) || Carbon::now()->gt($timeslot)) {
            return false;
        }

        if (floor(Carbon::now()->diffInMinutes($timeslot)) < $leadTimeMinutes) {
            return false;
        }

        if (!$this->isBetweenPeriodForDays($timeslot)) {
            return false;
        }

        // +2 as we subtracted a day and need to count the current day
        //        if (Carbon::instance($dateTime)->addDays($this->maxDays + 2)->lt($timeslot)) {
        //            return false;
        //        }
        // Commented out as not necessary. The above condition is already checked in isBetweenPeriodForDays method

        $result = WorkingScheduleTimeslotValidEvent::dispatchOnce($this, $timeslot);

        return is_bool($result) ? $result : true;
    }

    protected function hasPeriod(): bool
    {
        foreach ($this->periods as $period) {
            if (!$period->isEmpty()) {
                return true;
            }
        }

        foreach ($this->exceptions as $exception) {
            if (!$exception->isEmpty()) {
                return true;
            }
        }

        return false;
    }

    protected function createPeriodForDays(Carbon $dateTime): false|DatePeriod
    {
        $startDate = $dateTime->copy()->startOfDay()->subDays(2);
        if (!($startDate = $this->nextOpenAt($startDate)) instanceof DateTimeInterface) {
            return false;
        }

        $endDate = $dateTime->copy()->endOfDay()->addDays($this->maxDays);
        if ($this->forDate($endDate)->closesLate()) {
            $endDate->addDay();
        }

        $nextEndDate = $this->nextCloseAt($endDate->copy()->subDay());
        if ($nextEndDate instanceof DateTimeInterface && Carbon::instance($nextEndDate)->startOfDay()->lt(Carbon::instance($dateTime)->startOfDay())) {
            $endDate = Carbon::instance($nextEndDate)->addDay();
        }

        return new DatePeriod($startDate, new DateInterval('P1D'), $endDate);
    }

    protected function isBetweenPeriodForDays(DateTimeInterface $timeslot): bool
    {
        return Carbon::instance($timeslot)->between(
            now()->startOfDay()->addDays($this->minDays),
            now()->endOfDay()->addDays($this->maxDays + 2),
        );
    }
}
