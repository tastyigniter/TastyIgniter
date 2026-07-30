<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\ListSubscriptionEventsResponse;

/**
 * Builder for model ListSubscriptionEventsResponse
 *
 * @see ListSubscriptionEventsResponse
 */
class ListSubscriptionEventsResponseBuilder
{
    /**
     * @var ListSubscriptionEventsResponse
     */
    private $instance;

    private function __construct(ListSubscriptionEventsResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new list subscription events response Builder object.
     */
    public static function init(): self
    {
        return new self(new ListSubscriptionEventsResponse());
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
     * Sets subscription events field.
     */
    public function subscriptionEvents(?array $value): self
    {
        $this->instance->setSubscriptionEvents($value);
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
     * Initializes a new list subscription events response object.
     */
    public function build(): ListSubscriptionEventsResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
