<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\SearchCustomersResponse;

/**
 * Builder for model SearchCustomersResponse
 *
 * @see SearchCustomersResponse
 */
class SearchCustomersResponseBuilder
{
    /**
     * @var SearchCustomersResponse
     */
    private $instance;

    private function __construct(SearchCustomersResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new search customers response Builder object.
     */
    public static function init(): self
    {
        return new self(new SearchCustomersResponse());
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
     * Sets customers field.
     */
    public function customers(?array $value): self
    {
        $this->instance->setCustomers($value);
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
     * Initializes a new search customers response object.
     */
    public function build(): SearchCustomersResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
