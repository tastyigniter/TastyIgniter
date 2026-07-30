<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\SearchSubscriptionsResponse;

/**
 * Builder for model SearchSubscriptionsResponse
 *
 * @see SearchSubscriptionsResponse
 */
class SearchSubscriptionsResponseBuilder
{
    /**
     * @var SearchSubscriptionsResponse
     */
    private $instance;

    private function __construct(SearchSubscriptionsResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new search subscriptions response Builder object.
     */
    public static function init(): self
    {
        return new self(new SearchSubscriptionsResponse());
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
     * Sets subscriptions field.
     */
    public function subscriptions(?array $value): self
    {
        $this->instance->setSubscriptions($value);
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
     * Initializes a new search subscriptions response object.
     */
    public function build(): SearchSubscriptionsResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
