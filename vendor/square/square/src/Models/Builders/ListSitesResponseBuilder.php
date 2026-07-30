<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\ListSitesResponse;

/**
 * Builder for model ListSitesResponse
 *
 * @see ListSitesResponse
 */
class ListSitesResponseBuilder
{
    /**
     * @var ListSitesResponse
     */
    private $instance;

    private function __construct(ListSitesResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new list sites response Builder object.
     */
    public static function init(): self
    {
        return new self(new ListSitesResponse());
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
     * Sets sites field.
     */
    public function sites(?array $value): self
    {
        $this->instance->setSites($value);
        return $this;
    }

    /**
     * Initializes a new list sites response object.
     */
    public function build(): ListSitesResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
