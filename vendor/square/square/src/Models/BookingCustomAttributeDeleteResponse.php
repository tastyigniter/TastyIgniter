<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Represents a response for an individual upsert request in a
 * [BulkDeleteBookingCustomAttributes]($e/BookingCustomAttributes/BulkDeleteBookingCustomAttributes)
 * operation.
 */
class BookingCustomAttributeDeleteResponse implements \JsonSerializable
{
    /**
     * @var string|null
     */
    private $bookingId;

    /**
     * @var Error[]|null
     */
    private $errors;

    /**
     * Returns Booking Id.
     * The ID of the [booking](entity:Booking) associated with the custom attribute.
     */
    public function getBookingId(): ?string
    {
        return $this->bookingId;
    }

    /**
     * Sets Booking Id.
     * The ID of the [booking](entity:Booking) associated with the custom attribute.
     *
     * @maps booking_id
     */
    public function setBookingId(?string $bookingId): void
    {
        $this->bookingId = $bookingId;
    }

    /**
     * Returns Errors.
     * Any errors that occurred while processing the individual request.
     *
     * @return Error[]|null
     */
    public function getErrors(): ?array
    {
        return $this->errors;
    }

    /**
     * Sets Errors.
     * Any errors that occurred while processing the individual request.
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
        if (isset($this->bookingId)) {
            $json['booking_id'] = $this->bookingId;
        }
        if (isset($this->errors)) {
            $json['errors']     = $this->errors;
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
