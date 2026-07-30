<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\SearchAvailabilityResponse;

/**
 * Builder for model SearchAvailabilityResponse
 *
 * @see SearchAvailabilityResponse
 */
class SearchAvailabilityResponseBuilder
{
    /**
     * @var SearchAvailabilityResponse
     */
    private $instance;

    private function __construct(SearchAvailabilityResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new search availability response Builder object.
     */
    public static function init(): self
    {
        return new self(new SearchAvailabilityResponse());
    }

    /**
     * Sets availabilities field.
     */
    public function availabilities(?array $value): self
    {
        $this->instance->setAvailabilities($value);
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
     * Initializes a new search availability response object.
     */
    public function build(): SearchAvailabilityResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
