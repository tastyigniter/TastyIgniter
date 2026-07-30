<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

class RetrieveBusinessBookingProfileResponse implements \JsonSerializable
{
    /**
     * @var BusinessBookingProfile|null
     */
    private $businessBookingProfile;

    /**
     * @var Error[]|null
     */
    private $errors;

    /**
     * Returns Business Booking Profile.
     */
    public function getBusinessBookingProfile(): ?BusinessBookingProfile
    {
        return $this->businessBookingProfile;
    }

    /**
     * Sets Business Booking Profile.
     *
     * @maps business_booking_profile
     */
    public function setBusinessBookingProfile(?BusinessBookingProfile $businessBookingProfile): void
    {
        $this->businessBookingProfile = $businessBookingProfile;
    }

    /**
     * Returns Errors.
     * Errors that occurred during the request.
     *
     * @return Error[]|null
     */
    public function getErrors(): ?array
    {
        return $this->errors;
    }

    /**
     * Sets Errors.
     * Errors that occurred during the request.
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
        if (isset($this->businessBookingProfile)) {
            $json['business_booking_profile'] = $this->businessBookingProfile;
        }
        if (isset($this->errors)) {
            $json['errors']                   = $this->errors;
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
