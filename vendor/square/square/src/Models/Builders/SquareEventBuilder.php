<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\SquareEvent;
use Square\Models\SquareEventData;

/**
 * Builder for model SquareEvent
 *
 * @see SquareEvent
 */
class SquareEventBuilder
{
    /**
     * @var SquareEvent
     */
    private $instance;

    private function __construct(SquareEvent $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new square event Builder object.
     */
    public static function init(): self
    {
        return new self(new SquareEvent());
    }

    /**
     * Sets merchant id field.
     */
    public function merchantId(?string $value): self
    {
        $this->instance->setMerchantId($value);
        return $this;
    }

    /**
     * Unsets merchant id field.
     */
    public function unsetMerchantId(): self
    {
        $this->instance->unsetMerchantId();
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
     * Sets event id field.
     */
    public function eventId(?string $value): self
    {
        $this->instance->setEventId($value);
        return $this;
    }

    /**
     * Unsets event id field.
     */
    public function unsetEventId(): self
    {
        $this->instance->unsetEventId();
        return $this;
    }

    /**
     * Sets created at field.
     */
    public function createdAt(?string $value): self
    {
        $this->instance->setCreatedAt($value);
        return $this;
    }

    /**
     * Sets data field.
     */
    public function data(?SquareEventData $value): self
    {
        $this->instance->setData($value);
        return $this;
    }

    /**
     * Initializes a new square event object.
     */
    public function build(): SquareEvent
    {
        return CoreHelper::clone($this->instance);
    }
}
