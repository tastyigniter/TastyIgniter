<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\DeleteShiftResponse;

/**
 * Builder for model DeleteShiftResponse
 *
 * @see DeleteShiftResponse
 */
class DeleteShiftResponseBuilder
{
    /**
     * @var DeleteShiftResponse
     */
    private $instance;

    private function __construct(DeleteShiftResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new delete shift response Builder object.
     */
    public static function init(): self
    {
        return new self(new DeleteShiftResponse());
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
     * Initializes a new delete shift response object.
     */
    public function build(): DeleteShiftResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
