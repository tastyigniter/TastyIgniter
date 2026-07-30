<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\ListCardsRequest;

/**
 * Builder for model ListCardsRequest
 *
 * @see ListCardsRequest
 */
class ListCardsRequestBuilder
{
    /**
     * @var ListCardsRequest
     */
    private $instance;

    private function __construct(ListCardsRequest $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new list cards request Builder object.
     */
    public static function init(): self
    {
        return new self(new ListCardsRequest());
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
     * Sets customer id field.
     */
    public function customerId(?string $value): self
    {
        $this->instance->setCustomerId($value);
        return $this;
    }

    /**
     * Unsets customer id field.
     */
    public function unsetCustomerId(): self
    {
        $this->instance->unsetCustomerId();
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
     * Sets reference id field.
     */
    public function referenceId(?string $value): self
    {
        $this->instance->setReferenceId($value);
        return $this;
    }

    /**
     * Unsets reference id field.
     */
    public function unsetReferenceId(): self
    {
        $this->instance->unsetReferenceId();
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
     * Initializes a new list cards request object.
     */
    public function build(): ListCardsRequest
    {
        return CoreHelper::clone($this->instance);
    }
}
