<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\TimeRange;

/**
 * Builder for model TimeRange
 *
 * @see TimeRange
 */
class TimeRangeBuilder
{
    /**
     * @var TimeRange
     */
    private $instance;

    private function __construct(TimeRange $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new time range Builder object.
     */
    public static function init(): self
    {
        return new self(new TimeRange());
    }

    /**
     * Sets start at field.
     */
    public function startAt(?string $value): self
    {
        $this->instance->setStartAt($value);
        return $this;
    }

    /**
     * Unsets start at field.
     */
    public function unsetStartAt(): self
    {
        $this->instance->unsetStartAt();
        return $this;
    }

    /**
     * Sets end at field.
     */
    public function endAt(?string $value): self
    {
        $this->instance->setEndAt($value);
        return $this;
    }

    /**
     * Unsets end at field.
     */
    public function unsetEndAt(): self
    {
        $this->instance->unsetEndAt();
        return $this;
    }

    /**
     * Initializes a new time range object.
     */
    public function build(): TimeRange
    {
        return CoreHelper::clone($this->instance);
    }
}
