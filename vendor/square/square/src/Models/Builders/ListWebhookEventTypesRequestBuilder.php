<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\ListWebhookEventTypesRequest;

/**
 * Builder for model ListWebhookEventTypesRequest
 *
 * @see ListWebhookEventTypesRequest
 */
class ListWebhookEventTypesRequestBuilder
{
    /**
     * @var ListWebhookEventTypesRequest
     */
    private $instance;

    private function __construct(ListWebhookEventTypesRequest $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new list webhook event types request Builder object.
     */
    public static function init(): self
    {
        return new self(new ListWebhookEventTypesRequest());
    }

    /**
     * Sets api version field.
     */
    public function apiVersion(?string $value): self
    {
        $this->instance->setApiVersion($value);
        return $this;
    }

    /**
     * Unsets api version field.
     */
    public function unsetApiVersion(): self
    {
        $this->instance->unsetApiVersion();
        return $this;
    }

    /**
     * Initializes a new list webhook event types request object.
     */
    public function build(): ListWebhookEventTypesRequest
    {
        return CoreHelper::clone($this->instance);
    }
}
