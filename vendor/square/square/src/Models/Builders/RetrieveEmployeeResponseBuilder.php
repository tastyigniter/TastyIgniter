<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\Employee;
use Square\Models\RetrieveEmployeeResponse;

/**
 * Builder for model RetrieveEmployeeResponse
 *
 * @see RetrieveEmployeeResponse
 */
class RetrieveEmployeeResponseBuilder
{
    /**
     * @var RetrieveEmployeeResponse
     */
    private $instance;

    private function __construct(RetrieveEmployeeResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new retrieve employee response Builder object.
     */
    public static function init(): self
    {
        return new self(new RetrieveEmployeeResponse());
    }

    /**
     * Sets employee field.
     */
    public function employee(?Employee $value): self
    {
        $this->instance->setEmployee($value);
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
     * Initializes a new retrieve employee response object.
     */
    public function build(): RetrieveEmployeeResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
