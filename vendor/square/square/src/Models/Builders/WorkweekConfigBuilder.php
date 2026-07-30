<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\WorkweekConfig;

/**
 * Builder for model WorkweekConfig
 *
 * @see WorkweekConfig
 */
class WorkweekConfigBuilder
{
    /**
     * @var WorkweekConfig
     */
    private $instance;

    private function __construct(WorkweekConfig $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new workweek config Builder object.
     */
    public static function init(string $startOfWeek, string $startOfDayLocalTime): self
    {
        return new self(new WorkweekConfig($startOfWeek, $startOfDayLocalTime));
    }

    /**
     * Sets id field.
     */
    public function id(?string $value): self
    {
        $this->instance->setId($value);
        return $this;
    }

    /**
     * Sets version field.
     */
    public function version(?int $value): self
    {
        $this->instance->setVersion($value);
        return $this;
    }

    /**
     * Sets created at field.
     */
    public function createdAt(?string $value): self
    {
        $this->instance->setCreatedAt($value);
        return $this;
    }

    /**
     * Sets updated at field.
     */
    public function updatedAt(?string $value): self
    {
        $this->instance->setUpdatedAt($value);
        return $this;
    }

    /**
     * Initializes a new workweek config object.
     */
    public function build(): WorkweekConfig
    {
        return CoreHelper::clone($this->instance);
    }
}
