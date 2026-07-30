<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\SearchShiftsRequest;
use Square\Models\ShiftQuery;

/**
 * Builder for model SearchShiftsRequest
 *
 * @see SearchShiftsRequest
 */
class SearchShiftsRequestBuilder
{
    /**
     * @var SearchShiftsRequest
     */
    private $instance;

    private function __construct(SearchShiftsRequest $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new search shifts request Builder object.
     */
    public static function init(): self
    {
        return new self(new SearchShiftsRequest());
    }

    /**
     * Sets query field.
     */
    public function query(?ShiftQuery $value): self
    {
        $this->instance->setQuery($value);
        return $this;
    }

    /**
     * Sets limit field.
     */
    public function limit(?int $value): self
    {
        $this->instance->setLimit($value);
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
     * Initializes a new search shifts request object.
     */
    public function build(): SearchShiftsRequest
    {
        return CoreHelper::clone($this->instance);
    }
}
