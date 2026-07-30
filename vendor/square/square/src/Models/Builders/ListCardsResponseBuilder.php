<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\ListCardsResponse;

/**
 * Builder for model ListCardsResponse
 *
 * @see ListCardsResponse
 */
class ListCardsResponseBuilder
{
    /**
     * @var ListCardsResponse
     */
    private $instance;

    private function __construct(ListCardsResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new list cards response Builder object.
     */
    public static function init(): self
    {
        return new self(new ListCardsResponse());
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
     * Sets cards field.
     */
    public function cards(?array $value): self
    {
        $this->instance->setCards($value);
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
     * Initializes a new list cards response object.
     */
    public function build(): ListCardsResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
