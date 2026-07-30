<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\Location;
use Square\Models\UpdateLocationRequest;

/**
 * Builder for model UpdateLocationRequest
 *
 * @see UpdateLocationRequest
 */
class UpdateLocationRequestBuilder
{
    /**
     * @var UpdateLocationRequest
     */
    private $instance;

    private function __construct(UpdateLocationRequest $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new update location request Builder object.
     */
    public static function init(): self
    {
        return new self(new UpdateLocationRequest());
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
     * Initializes a new update location request object.
     */
    public function build(): UpdateLocationRequest
    {
        return CoreHelper::clone($this->instance);
    }
}
