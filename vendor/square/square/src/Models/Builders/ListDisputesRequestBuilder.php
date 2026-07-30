<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\ListDisputesRequest;

/**
 * Builder for model ListDisputesRequest
 *
 * @see ListDisputesRequest
 */
class ListDisputesRequestBuilder
{
    /**
     * @var ListDisputesRequest
     */
    private $instance;

    private function __construct(ListDisputesRequest $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new list disputes request Builder object.
     */
    public static function init(): self
    {
        return new self(new ListDisputesRequest());
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
     * Sets states field.
     */
    public function states(?array $value): self
    {
        $this->instance->setStates($value);
        return $this;
    }

    /**
     * Unsets states field.
     */
    public function unsetStates(): self
    {
        $this->instance->unsetStates();
        return $this;
    }

    /**
     * Sets location id field.
     */
    public function locationId(?string $value): self
    {
        $this->instance->setLocationId($value);
        return $this;
    }

    /**
     * Unsets location id field.
     */
    public function unsetLocationId(): self
    {
        $this->instance->unsetLocationId();
        return $this;
    }

    /**
     * Initializes a new list disputes request object.
     */
    public function build(): ListDisputesRequest
    {
        return CoreHelper::clone($this->instance);
    }
}
