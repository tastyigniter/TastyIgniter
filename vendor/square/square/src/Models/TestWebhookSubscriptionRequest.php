<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Tests a [Subscription]($m/WebhookSubscription) by sending a test event to its notification URL.
 */
class TestWebhookSubscriptionRequest implements \JsonSerializable
{
    /**
     * @var array
     */
    private $eventType = [];

    /**
     * Returns Event Type.
     * The event type that will be used to test the [Subscription](entity:WebhookSubscription). The event
     * type must be
     * contained in the list of event types in the [Subscription](entity:WebhookSubscription).
     */
    public function getEventType(): ?string
    {
        if (count($this->eventType) == 0) {
            return null;
        }
        return $this->eventType['value'];
    }

    /**
     * Sets Event Type.
     * The event type that will be used to test the [Subscription](entity:WebhookSubscription). The event
     * type must be
     * contained in the list of event types in the [Subscription](entity:WebhookSubscription).
     *
     * @maps event_type
     */
    public function setEventType(?string $eventType): void
    {
        $this->eventType['value'] = $eventType;
    }

    /**
     * Unsets Event Type.
     * The event type that will be used to test the [Subscription](entity:WebhookSubscription). The event
     * type must be
     * contained in the list of event types in the [Subscription](entity:WebhookSubscription).
     */
    public function unsetEventType(): void
    {
        $this->eventType = [];
    }

    /**
     * Encode this object to JSON
     *
     * @param bool $asArrayWhenEmpty Whether to serialize this model as an array whenever no fields
     *        are set. (default: false)
     *
     * @return array|stdClass
     */
    #[\ReturnTypeWillChange] // @phan-suppress-current-line PhanUndeclaredClassAttribute for (php < 8.1)
    public function jsonSerialize(bool $asArrayWhenEmpty = false)
    {
        $json = [];
        if (!empty($this->eventType)) {
            $json['event_type'] = $this->eventType['value'];
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
