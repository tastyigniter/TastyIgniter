<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\ListGiftCardsResponse;

/**
 * Builder for model ListGiftCardsResponse
 *
 * @see ListGiftCardsResponse
 */
class ListGiftCardsResponseBuilder
{
    /**
     * @var ListGiftCardsResponse
     */
    private $instance;

    private function __construct(ListGiftCardsResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new list gift cards response Builder object.
     */
    public static function init(): self
    {
        return new self(new ListGiftCardsResponse());
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
     * Sets gift cards field.
     */
    public function giftCards(?array $value): self
    {
        $this->instance->setGiftCards($value);
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
     * Initializes a new list gift cards response object.
     */
    public function build(): ListGiftCardsResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
