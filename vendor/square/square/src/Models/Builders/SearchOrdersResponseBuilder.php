<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\SearchOrdersResponse;

/**
 * Builder for model SearchOrdersResponse
 *
 * @see SearchOrdersResponse
 */
class SearchOrdersResponseBuilder
{
    /**
     * @var SearchOrdersResponse
     */
    private $instance;

    private function __construct(SearchOrdersResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new search orders response Builder object.
     */
    public static function init(): self
    {
        return new self(new SearchOrdersResponse());
    }

    /**
     * Sets order entries field.
     */
    public function orderEntries(?array $value): self
    {
        $this->instance->setOrderEntries($value);
        return $this;
    }

    /**
     * Sets orders field.
     */
    public function orders(?array $value): self
    {
        $this->instance->setOrders($value);
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
     * Initializes a new search orders response object.
     */
    public function build(): SearchOrdersResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
