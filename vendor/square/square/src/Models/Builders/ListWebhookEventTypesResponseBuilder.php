<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\ListWebhookEventTypesResponse;

/**
 * Builder for model ListWebhookEventTypesResponse
 *
 * @see ListWebhookEventTypesResponse
 */
class ListWebhookEventTypesResponseBuilder
{
    /**
     * @var ListWebhookEventTypesResponse
     */
    private $instance;

    private function __construct(ListWebhookEventTypesResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new list webhook event types response Builder object.
     */
    public static function init(): self
    {
        return new self(new ListWebhookEventTypesResponse());
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
     * Sets event types field.
     */
    public function eventTypes(?array $value): self
    {
        $this->instance->setEventTypes($value);
        return $this;
    }

    /**
     * Sets metadata field.
     */
    public function metadata(?array $value): self
    {
        $this->instance->setMetadata($value);
        return $this;
    }

    /**
     * Initializes a new list webhook event types response object.
     */
    public function build(): ListWebhookEventTypesResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
