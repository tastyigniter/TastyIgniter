<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\TerminalCheckoutQueryFilter;
use Square\Models\TimeRange;

/**
 * Builder for model TerminalCheckoutQueryFilter
 *
 * @see TerminalCheckoutQueryFilter
 */
class TerminalCheckoutQueryFilterBuilder
{
    /**
     * @var TerminalCheckoutQueryFilter
     */
    private $instance;

    private function __construct(TerminalCheckoutQueryFilter $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new terminal checkout query filter Builder object.
     */
    public static function init(): self
    {
        return new self(new TerminalCheckoutQueryFilter());
    }

    /**
     * Sets device id field.
     */
    public function deviceId(?string $value): self
    {
        $this->instance->setDeviceId($value);
        return $this;
    }

    /**
     * Unsets device id field.
     */
    public function unsetDeviceId(): self
    {
        $this->instance->unsetDeviceId();
        return $this;
    }

    /**
     * Sets created at field.
     */
    public function createdAt(?TimeRange $value): self
    {
        $this->instance->setCreatedAt($value);
        return $this;
    }

    /**
     * Sets status field.
     */
    public function status(?string $value): self
    {
        $this->instance->setStatus($value);
        return $this;
    }

    /**
     * Unsets status field.
     */
    public function unsetStatus(): self
    {
        $this->instance->unsetStatus();
        return $this;
    }

    /**
     * Initializes a new terminal checkout query filter object.
     */
    public function build(): TerminalCheckoutQueryFilter
    {
        return CoreHelper::clone($this->instance);
    }
}
