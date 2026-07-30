<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\TerminalRefundQueryFilter;
use Square\Models\TimeRange;

/**
 * Builder for model TerminalRefundQueryFilter
 *
 * @see TerminalRefundQueryFilter
 */
class TerminalRefundQueryFilterBuilder
{
    /**
     * @var TerminalRefundQueryFilter
     */
    private $instance;

    private function __construct(TerminalRefundQueryFilter $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new terminal refund query filter Builder object.
     */
    public static function init(): self
    {
        return new self(new TerminalRefundQueryFilter());
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
     * Initializes a new terminal refund query filter object.
     */
    public function build(): TerminalRefundQueryFilter
    {
        return CoreHelper::clone($this->instance);
    }
}
