<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\ListCashDrawerShiftsRequest;

/**
 * Builder for model ListCashDrawerShiftsRequest
 *
 * @see ListCashDrawerShiftsRequest
 */
class ListCashDrawerShiftsRequestBuilder
{
    /**
     * @var ListCashDrawerShiftsRequest
     */
    private $instance;

    private function __construct(ListCashDrawerShiftsRequest $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new list cash drawer shifts request Builder object.
     */
    public static function init(string $locationId): self
    {
        return new self(new ListCashDrawerShiftsRequest($locationId));
    }

    /**
     * Sets sort order field.
     */
    public function sortOrder(?string $value): self
    {
        $this->instance->setSortOrder($value);
        return $this;
    }

    /**
     * Sets begin time field.
     */
    public function beginTime(?string $value): self
    {
        $this->instance->setBeginTime($value);
        return $this;
    }

    /**
     * Unsets begin time field.
     */
    public function unsetBeginTime(): self
    {
        $this->instance->unsetBeginTime();
        return $this;
    }

    /**
     * Sets end time field.
     */
    public function endTime(?string $value): self
    {
        $this->instance->setEndTime($value);
        return $this;
    }

    /**
     * Unsets end time field.
     */
    public function unsetEndTime(): self
    {
        $this->instance->unsetEndTime();
        return $this;
    }

    /**
     * Sets limit field.
     */
    public function limit(?int $value): self
    {
        $this->instance->setLimit($value);
        return $this;
    }

    /**
     * Unsets limit field.
     */
    public function unsetLimit(): self
    {
        $this->instance->unsetLimit();
        return $this;
    }

    /**
     * Sets cursor field.
     */
    public function cursor(?string $value): self
    {
        $this->instance->setCursor($value);
        return $this;
    }

    /**
     * Unsets cursor field.
     */
    public function unsetCursor(): self
    {
        $this->instance->unsetCursor();
        return $this;
    }

    /**
     * Initializes a new list cash drawer shifts request object.
     */
    public function build(): ListCashDrawerShiftsRequest
    {
        return CoreHelper::clone($this->instance);
    }
}
