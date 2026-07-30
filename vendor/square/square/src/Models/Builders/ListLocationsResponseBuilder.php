<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\ListLocationsResponse;

/**
 * Builder for model ListLocationsResponse
 *
 * @see ListLocationsResponse
 */
class ListLocationsResponseBuilder
{
    /**
     * @var ListLocationsResponse
     */
    private $instance;

    private function __construct(ListLocationsResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new list locations response Builder object.
     */
    public static function init(): self
    {
        return new self(new ListLocationsResponse());
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
     * Sets locations field.
     */
    public function locations(?array $value): self
    {
        $this->instance->setLocations($value);
        return $this;
    }

    /**
     * Initializes a new list locations response object.
     */
    public function build(): ListLocationsResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
