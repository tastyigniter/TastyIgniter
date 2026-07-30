<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\GetShiftResponse;
use Square\Models\Shift;

/**
 * Builder for model GetShiftResponse
 *
 * @see GetShiftResponse
 */
class GetShiftResponseBuilder
{
    /**
     * @var GetShiftResponse
     */
    private $instance;

    private function __construct(GetShiftResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new get shift response Builder object.
     */
    public static function init(): self
    {
        return new self(new GetShiftResponse());
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
     * Initializes a new get shift response object.
     */
    public function build(): GetShiftResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
