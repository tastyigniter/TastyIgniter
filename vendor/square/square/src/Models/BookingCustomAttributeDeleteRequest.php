<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Represents an individual delete request in a
 * [BulkDeleteBookingCustomAttributes]($e/BookingCustomAttributes/BulkDeleteBookingCustomAttributes)
 * request. An individual request contains a booking ID, the custom attribute to delete, and an
 * optional idempotency key.
 */
class BookingCustomAttributeDeleteRequest implements \JsonSerializable
{
    /**
     * @var string
     */
    private $bookingId;

    /**
     * @var string
     */
    private $key;

    /**
     * @param string $bookingId
     * @param string $key
     */
    public function __construct(string $bookingId, string $key)
    {
        $this->bookingId = $bookingId;
        $this->key = $key;
    }

    /**
     * Returns Booking Id.
     * The ID of the target [booking](entity:Booking).
     */
    public function getBookingId(): string
    {
        return $this->bookingId;
    }

    /**
     * Sets Booking Id.
     * The ID of the target [booking](entity:Booking).
     *
     * @required
     * @maps booking_id
     */
    public function setBookingId(string $bookingId): void
    {
        $this->bookingId = $bookingId;
    }

    /**
     * Returns Key.
     * The key of the custom attribute to delete. This key must match the `key` of a
     * custom attribute definition in the Square seller account. If the requesting application is not
     * the definition owner, you must use the qualified key.
     */
    public function getKey(): string
    {
        return $this->key;
    }

    /**
     * Sets Key.
     * The key of the custom attribute to delete. This key must match the `key` of a
     * custom attribute definition in the Square seller account. If the requesting application is not
     * the definition owner, you must use the qualified key.
     *
     * @required
     * @maps key
     */
    public function setKey(string $key): void
    {
        $this->key = $key;
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
        $json['booking_id'] = $this->bookingId;
        $json['key']        = $this->key;
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
