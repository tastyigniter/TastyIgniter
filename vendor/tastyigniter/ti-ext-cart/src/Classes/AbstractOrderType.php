<?php

declare(strict_types=1);

namespace Igniter\Cart\Classes;

use Igniter\Cart\Contracts\OrderTypeInterface;
use Igniter\Local\Classes\WorkingSchedule;
use Igniter\Local\Models\Location;

abstract class AbstractOrderType implements OrderTypeInterface
{
    public const int ASAP_ONLY = 1;

    public const int LATER_ONLY = 2;

    protected ?string $code = null;

    protected ?string $name = null;

    protected ?WorkingSchedule $schedule = null;

    public function __construct(protected Location $location, protected array $config)
    {
        $this->code = $this->config['code'];
        $this->name = $this->config['name'];
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function getLabel(): string
    {
        return lang($this->name);
    }

    public function getInterval(): int
    {
        return $this->location->getOrderTimeInterval($this->code);
    }

    public function getLeadTime(): int
    {
        return $this->location->getOrderLeadTime($this->code);
    }

    public function getFutureDays(): int
    {
        return $this->location->hasFutureOrder($this->code)
            ? $this->location->futureOrderDays($this->code)
            : 0;
    }

    public function getMinimumFutureDays(): int
    {
        return $this->location->hasFutureOrder($this->code)
            ? $this->location->minimumFutureOrderDays($this->code)
            : 0;
    }

    public function getMinimumOrderTotal()
    {
        return $this->location->getMinimumOrderTotal($this->code);
    }

    public function getSchedule(): WorkingSchedule
    {
        if (!is_null($this->schedule)) {
            return $this->schedule;
        }

        $schedule = $this->location->newWorkingSchedule(
            $this->code, [$this->getMinimumFutureDays(), $this->getFutureDays()],
        );

        return $this->schedule = $schedule;
    }

    public function getScheduleRestriction(): int
    {
        if ($this->location->getSettings('checkout.limit_orders')) {
            return static::LATER_ONLY;
        }

        if ($this->location->hasFutureOrder($this->code)) {
            return 0;
        }

        return $this->location->getOrderTimeRestriction($this->code);
    }
}
