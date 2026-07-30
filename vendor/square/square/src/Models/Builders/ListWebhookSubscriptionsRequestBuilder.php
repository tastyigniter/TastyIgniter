<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\ListWebhookSubscriptionsRequest;

/**
 * Builder for model ListWebhookSubscriptionsRequest
 *
 * @see ListWebhookSubscriptionsRequest
 */
class ListWebhookSubscriptionsRequestBuilder
{
    /**
     * @var ListWebhookSubscriptionsRequest
     */
    private $instance;

    private function __construct(ListWebhookSubscriptionsRequest $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new list webhook subscriptions request Builder object.
     */
    public static function init(): self
    {
        return new self(new ListWebhookSubscriptionsRequest());
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
     * Unsets cursor field.
     */
    public function unsetCursor(): self
    {
        $this->instance->unsetCursor();
        return $this;
    }

    /**
     * Sets include disabled field.
     */
    public function includeDisabled(?bool $value): self
    {
        $this->instance->setIncludeDisabled($value);
        return $this;
    }

    /**
     * Unsets include disabled field.
     */
    public function unsetIncludeDisabled(): self
    {
        $this->instance->unsetIncludeDisabled();
        return $this;
    }

    /**
     * Sets sort order field.
     */
    public function sortOrder(?string $value): self
    {
        $this->instance->setSortOrder($value);
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
     * Unsets limit field.
     */
    public function unsetLimit(): self
    {
        $this->instance->unsetLimit();
        return $this;
    }

    /**
     * Initializes a new list webhook subscriptions request object.
     */
    public function build(): ListWebhookSubscriptionsRequest
    {
        return CoreHelper::clone($this->instance);
    }
}
