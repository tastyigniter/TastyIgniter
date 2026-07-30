<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\ListEmployeesResponse;

/**
 * Builder for model ListEmployeesResponse
 *
 * @see ListEmployeesResponse
 */
class ListEmployeesResponseBuilder
{
    /**
     * @var ListEmployeesResponse
     */
    private $instance;

    private function __construct(ListEmployeesResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new list employees response Builder object.
     */
    public static function init(): self
    {
        return new self(new ListEmployeesResponse());
    }

    /**
     * Sets employees field.
     */
    public function employees(?array $value): self
    {
        $this->instance->setEmployees($value);
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
     * Initializes a new list employees response object.
     */
    public function build(): ListEmployeesResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
