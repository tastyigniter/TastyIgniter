<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\CreateShiftResponse;
use Square\Models\Shift;

/**
 * Builder for model CreateShiftResponse
 *
 * @see CreateShiftResponse
 */
class CreateShiftResponseBuilder
{
    /**
     * @var CreateShiftResponse
     */
    private $instance;

    private function __construct(CreateShiftResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new create shift response Builder object.
     */
    public static function init(): self
    {
        return new self(new CreateShiftResponse());
    }

    /**
     * Sets shift field.
     */
    public function shift(?Shift $value): self
    {
        $this->instance->setShift($value);
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
     * Initializes a new create shift response object.
     */
    public function build(): CreateShiftResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
