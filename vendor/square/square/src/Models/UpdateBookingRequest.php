<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

class UpdateBookingRequest implements \JsonSerializable
{
    /**
     * @var array
     */
    private $idempotencyKey = [];

    /**
     * @var Booking
     */
    private $booking;

    /**
     * @param Booking $booking
     */
    public function __construct(Booking $booking)
    {
        $this->booking = $booking;
    }

    /**
     * Returns Idempotency Key.
     * A unique key to make this request an idempotent operation.
     */
    public function getIdempotencyKey(): ?string
    {
        if (count($this->idempotencyKey) == 0) {
            return null;
        }
        return $this->idempotencyKey['value'];
    }

    /**
     * Sets Idempotency Key.
     * A unique key to make this request an idempotent operation.
     *
     * @maps idempotency_key
     */
    public function setIdempotencyKey(?string $idempotencyKey): void
    {
        $this->idempotencyKey['value'] = $idempotencyKey;
    }

    /**
     * Unsets Idempotency Key.
     * A unique key to make this request an idempotent operation.
     */
    public function unsetIdempotencyKey(): void
    {
        $this->idempotencyKey = [];
    }

    /**
     * Returns Booking.
     * Represents a booking as a time-bound service contract for a seller's staff member to provide a
     * specified service
     * at a given location to a requesting customer in one or more appointment segments.
     */
    public function getBooking(): Booking
    {
        return $this->booking;
    }

    /**
     * Sets Booking.
     * Represents a booking as a time-bound service contract for a seller's staff member to provide a
     * specified service
     * at a given location to a requesting customer in one or more appointment segments.
     *
     * @required
     * @maps booking
     */
    public function setBooking(Booking $booking): void
    {
        $this->booking = $booking;
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
        if (!empty($this->idempotencyKey)) {
            $json['idempotency_key'] = $this->idempotencyKey['value'];
        }
        $json['booking']             = $this->booking;
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
