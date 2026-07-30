<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\CreateLocationResponse;
use Square\Models\Location;

/**
 * Builder for model CreateLocationResponse
 *
 * @see CreateLocationResponse
 */
class CreateLocationResponseBuilder
{
    /**
     * @var CreateLocationResponse
     */
    private $instance;

    private function __construct(CreateLocationResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new create location response Builder object.
     */
    public static function init(): self
    {
        return new self(new CreateLocationResponse());
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
     * Sets location field.
     */
    public function location(?Location $value): self
    {
        $this->instance->setLocation($value);
        return $this;
    }

    /**
     * Initializes a new create location response object.
     */
    public function build(): CreateLocationResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
