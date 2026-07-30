<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Defines an appointment slot that encapsulates the appointment segments, location and starting time
 * available for booking.
 */
class Availability implements \JsonSerializable
{
    /**
     * @var array
     */
    private $startAt = [];

    /**
     * @var string|null
     */
    private $locationId;

    /**
     * @var array
     */
    private $appointmentSegments = [];

    /**
     * Returns Start At.
     * The RFC 3339 timestamp specifying the beginning time of the slot available for booking.
     */
    public function getStartAt(): ?string
    {
        if (count($this->startAt) == 0) {
            return null;
        }
        return $this->startAt['value'];
    }

    /**
     * Sets Start At.
     * The RFC 3339 timestamp specifying the beginning time of the slot available for booking.
     *
     * @maps start_at
     */
    public function setStartAt(?string $startAt): void
    {
        $this->startAt['value'] = $startAt;
    }

    /**
     * Unsets Start At.
     * The RFC 3339 timestamp specifying the beginning time of the slot available for booking.
     */
    public function unsetStartAt(): void
    {
        $this->startAt = [];
    }

    /**
     * Returns Location Id.
     * The ID of the location available for booking.
     */
    public function getLocationId(): ?string
    {
        return $this->locationId;
    }

    /**
     * Sets Location Id.
     * The ID of the location available for booking.
     *
     * @maps location_id
     */
    public function setLocationId(?string $locationId): void
    {
        $this->locationId = $locationId;
    }

    /**
     * Returns Appointment Segments.
     * The list of appointment segments available for booking
     *
     * @return AppointmentSegment[]|null
     */
    public function getAppointmentSegments(): ?array
    {
        if (count($this->appointmentSegments) == 0) {
            return null;
        }
        return $this->appointmentSegments['value'];
    }

    /**
     * Sets Appointment Segments.
     * The list of appointment segments available for booking
     *
     * @maps appointment_segments
     *
     * @param AppointmentSegment[]|null $appointmentSegments
     */
    public function setAppointmentSegments(?array $appointmentSegments): void
    {
        $this->appointmentSegments['value'] = $appointmentSegments;
    }

    /**
     * Unsets Appointment Segments.
     * The list of appointment segments available for booking
     */
    public function unsetAppointmentSegments(): void
    {
        $this->appointmentSegments = [];
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
        if (!empty($this->startAt)) {
            $json['start_at']             = $this->startAt['value'];
        }
        if (isset($this->locationId)) {
            $json['location_id']          = $this->locationId;
        }
        if (!empty($this->appointmentSegments)) {
            $json['appointment_segments'] = $this->appointmentSegments['value'];
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
