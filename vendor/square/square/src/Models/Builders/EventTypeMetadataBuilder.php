<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\EventTypeMetadata;

/**
 * Builder for model EventTypeMetadata
 *
 * @see EventTypeMetadata
 */
class EventTypeMetadataBuilder
{
    /**
     * @var EventTypeMetadata
     */
    private $instance;

    private function __construct(EventTypeMetadata $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new event type metadata Builder object.
     */
    public static function init(): self
    {
        return new self(new EventTypeMetadata());
    }

    /**
     * Sets event type field.
     */
    public function eventType(?string $value): self
    {
        $this->instance->setEventType($value);
        return $this;
    }

    /**
     * Sets api version introduced field.
     */
    public function apiVersionIntroduced(?string $value): self
    {
        $this->instance->setApiVersionIntroduced($value);
        return $this;
    }

    /**
     * Sets release status field.
     */
    public function releaseStatus(?string $value): self
    {
        $this->instance->setReleaseStatus($value);
        return $this;
    }

    /**
     * Initializes a new event type metadata object.
     */
    public function build(): EventTypeMetadata
    {
        return CoreHelper::clone($this->instance);
    }
}
