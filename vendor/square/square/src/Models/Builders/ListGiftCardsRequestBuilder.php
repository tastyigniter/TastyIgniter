<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\ListGiftCardsRequest;

/**
 * Builder for model ListGiftCardsRequest
 *
 * @see ListGiftCardsRequest
 */
class ListGiftCardsRequestBuilder
{
    /**
     * @var ListGiftCardsRequest
     */
    private $instance;

    private function __construct(ListGiftCardsRequest $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new list gift cards request Builder object.
     */
    public static function init(): self
    {
        return new self(new ListGiftCardsRequest());
    }

    /**
     * Sets type field.
     */
    public function type(?string $value): self
    {
        $this->instance->setType($value);
        return $this;
    }

    /**
     * Unsets type field.
     */
    public function unsetType(): self
    {
        $this->instance->unsetType();
        return $this;
    }

    /**
     * Sets state field.
     */
    public function state(?string $value): self
    {
        $this->instance->setState($value);
        return $this;
    }

    /**
     * Unsets state field.
     */
    public function unsetState(): self
    {
        $this->instance->unsetState();
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
     * Initializes a new list gift cards request object.
     */
    public function build(): ListGiftCardsRequest
    {
        return CoreHelper::clone($this->instance);
    }
}
