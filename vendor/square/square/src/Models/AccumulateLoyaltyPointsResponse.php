<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Represents an [AccumulateLoyaltyPoints]($e/Loyalty/AccumulateLoyaltyPoints) response.
 */
class AccumulateLoyaltyPointsResponse implements \JsonSerializable
{
    /**
     * @var Error[]|null
     */
    private $errors;

    /**
     * @var LoyaltyEvent|null
     */
    private $event;

    /**
     * @var LoyaltyEvent[]|null
     */
    private $events;

    /**
     * Returns Errors.
     * Any errors that occurred during the request.
     *
     * @return Error[]|null
     */
    public function getErrors(): ?array
    {
        return $this->errors;
    }

    /**
     * Sets Errors.
     * Any errors that occurred during the request.
     *
     * @maps errors
     *
     * @param Error[]|null $errors
     */
    public function setErrors(?array $errors): void
    {
        $this->errors = $errors;
    }

    /**
     * Returns Event.
     * Provides information about a loyalty event.
     * For more information, see [Search for Balance-Changing Loyalty Events](https://developer.squareup.
     * com/docs/loyalty-api/loyalty-events).
     */
    public function getEvent(): ?LoyaltyEvent
    {
        return $this->event;
    }

    /**
     * Sets Event.
     * Provides information about a loyalty event.
     * For more information, see [Search for Balance-Changing Loyalty Events](https://developer.squareup.
     * com/docs/loyalty-api/loyalty-events).
     *
     * @maps event
     */
    public function setEvent(?LoyaltyEvent $event): void
    {
        $this->event = $event;
    }

    /**
     * Returns Events.
     * The resulting loyalty events. If the purchase qualifies for points, the `ACCUMULATE_POINTS` event
     * is always included. When using the Orders API, the `ACCUMULATE_PROMOTION_POINTS` event is included
     * if the purchase also qualifies for a loyalty promotion.
     *
     * @return LoyaltyEvent[]|null
     */
    public function getEvents(): ?array
    {
        return $this->events;
    }

    /**
     * Sets Events.
     * The resulting loyalty events. If the purchase qualifies for points, the `ACCUMULATE_POINTS` event
     * is always included. When using the Orders API, the `ACCUMULATE_PROMOTION_POINTS` event is included
     * if the purchase also qualifies for a loyalty promotion.
     *
     * @maps events
     *
     * @param LoyaltyEvent[]|null $events
     */
    public function setEvents(?array $events): void
    {
        $this->events = $events;
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
        if (isset($this->errors)) {
            $json['errors'] = $this->errors;
        }
        if (isset($this->event)) {
            $json['event']  = $this->event;
        }
        if (isset($this->events)) {
            $json['events'] = $this->events;
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
