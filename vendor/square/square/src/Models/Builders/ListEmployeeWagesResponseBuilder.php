<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\ListEmployeeWagesResponse;

/**
 * Builder for model ListEmployeeWagesResponse
 *
 * @see ListEmployeeWagesResponse
 */
class ListEmployeeWagesResponseBuilder
{
    /**
     * @var ListEmployeeWagesResponse
     */
    private $instance;

    private function __construct(ListEmployeeWagesResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new list employee wages response Builder object.
     */
    public static function init(): self
    {
        return new self(new ListEmployeeWagesResponse());
    }

    /**
     * Sets employee wages field.
     */
    public function employeeWages(?array $value): self
    {
        $this->instance->setEmployeeWages($value);
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
     * Sets errors field.
     */
    public function errors(?array $value): self
    {
        $this->instance->setErrors($value);
        return $this;
    }

    /**
     * Initializes a new list employee wages response object.
     */
    public function build(): ListEmployeeWagesResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
