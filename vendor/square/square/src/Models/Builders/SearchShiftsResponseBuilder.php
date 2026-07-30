<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\SearchShiftsResponse;

/**
 * Builder for model SearchShiftsResponse
 *
 * @see SearchShiftsResponse
 */
class SearchShiftsResponseBuilder
{
    /**
     * @var SearchShiftsResponse
     */
    private $instance;

    private function __construct(SearchShiftsResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new search shifts response Builder object.
     */
    public static function init(): self
    {
        return new self(new SearchShiftsResponse());
    }

    /**
     * Sets shifts field.
     */
    public function shifts(?array $value): self
    {
        $this->instance->setShifts($value);
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
     * Initializes a new search shifts response object.
     */
    public function build(): SearchShiftsResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
