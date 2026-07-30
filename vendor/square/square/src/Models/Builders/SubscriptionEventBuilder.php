<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\SubscriptionEvent;
use Square\Models\SubscriptionEventInfo;

/**
 * Builder for model SubscriptionEvent
 *
 * @see SubscriptionEvent
 */
class SubscriptionEventBuilder
{
    /**
     * @var SubscriptionEvent
     */
    private $instance;

    private function __construct(SubscriptionEvent $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new subscription event Builder object.
     */
    public static function init(string $id, string $subscriptionEventType, string $effectiveDate, string $planId): self
    {
        return new self(new SubscriptionEvent($id, $subscriptionEventType, $effectiveDate, $planId));
    }

    /**
     * Sets info field.
     */
    public function info(?SubscriptionEventInfo $value): self
    {
        $this->instance->setInfo($value);
        return $this;
    }

    /**
     * Initializes a new subscription event object.
     */
    public function build(): SubscriptionEvent
    {
        return CoreHelper::clone($this->instance);
    }
}
