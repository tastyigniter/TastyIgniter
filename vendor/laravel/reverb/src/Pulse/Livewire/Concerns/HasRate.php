<?php

namespace Laravel\Reverb\Pulse\Livewire\Concerns;

use Carbon\CarbonInterval;

trait HasRate
{
    /**
     * The message send rate.
     */
    protected function rate(?float $count): ?float
    {
        return $count ? round($count * $this->rateMultiplier(), 2) : null;
    }

    /**
     * The rate multiplier.
     */
    protected function rateMultiplier(): float
    {
        return with(match ($this->period) {
            '6_hours' => CarbonInterval::minute(),
            '24_hours' => CarbonInterval::hour(),
            '7_days' => CarbonInterval::day(),
            default => CarbonInterval::second(),
        }, fn ($period) => $period->totalSeconds > $this->secondsPerBucket()
            ? $this->secondsPerBucket() / $period->totalSeconds
            : $period->totalSeconds / $this->secondsPerBucket());
    }

    /**
     * The seconds per bucket.
     */
    protected function secondsPerBucket(): float
    {
        return $this->periodAsInterval()->totalSeconds / $maxDataPoints = 60;
    }

    /**
     * The rate unit.
     */
    protected function rateUnit(): string
    {
        return match ($this->period) {
            '6_hours' => 'minute',
            '24_hours' => 'hour',
            '7_days' => 'day',
            default => 'second',
        };
    }
}
