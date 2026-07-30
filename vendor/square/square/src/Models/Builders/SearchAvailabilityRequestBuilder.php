<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\SearchAvailabilityQuery;
use Square\Models\SearchAvailabilityRequest;

/**
 * Builder for model SearchAvailabilityRequest
 *
 * @see SearchAvailabilityRequest
 */
class SearchAvailabilityRequestBuilder
{
    /**
     * @var SearchAvailabilityRequest
     */
    private $instance;

    private function __construct(SearchAvailabilityRequest $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new search availability request Builder object.
     */
    public static function init(SearchAvailabilityQuery $query): self
    {
        return new self(new SearchAvailabilityRequest($query));
    }

    /**
     * Initializes a new search availability request object.
     */
    public function build(): SearchAvailabilityRequest
    {
        return CoreHelper::clone($this->instance);
    }
}
