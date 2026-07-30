<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

class CancelBookingRequest implements \JsonSerializable
{
    /**
     * @var array
     */
    private $idempotencyKey = [];

    /**
     * @var array
     */
    private $bookingVersion = [];

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
     * Returns Booking Version.
     * The revision number for the booking used for optimistic concurrency.
     */
    public function getBookingVersion(): ?int
    {
        if (count($this->bookingVersion) == 0) {
            return null;
        }
        return $this->bookingVersion['value'];
    }

    /**
     * Sets Booking Version.
     * The revision number for the booking used for optimistic concurrency.
     *
     * @maps booking_version
     */
    public function setBookingVersion(?int $bookingVersion): void
    {
        $this->bookingVersion['value'] = $bookingVersion;
    }

    /**
     * Unsets Booking Version.
     * The revision number for the booking used for optimistic concurrency.
     */
    public function unsetBookingVersion(): void
    {
        $this->bookingVersion = [];
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
        if (!empty($this->bookingVersion)) {
            $json['booking_version'] = $this->bookingVersion['value'];
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
