<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Defines the fields that are included in the response body for requests to the
 * `RetrieveCustomerSegment` endpoint.
 *
 * Either `errors` or `segment` is present in a given response (never both).
 */
class RetrieveCustomerSegmentResponse implements \JsonSerializable
{
    /**
     * @var Error[]|null
     */
    private $errors;

    /**
     * @var CustomerSegment|null
     */
    private $segment;

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
     * Returns Segment.
     * Represents a group of customer profiles that match one or more predefined filter criteria.
     *
     * Segments (also known as Smart Groups) are defined and created within the Customer Directory in the
     * Square Seller Dashboard or Point of Sale.
     */
    public function getSegment(): ?CustomerSegment
    {
        return $this->segment;
    }

    /**
     * Sets Segment.
     * Represents a group of customer profiles that match one or more predefined filter criteria.
     *
     * Segments (also known as Smart Groups) are defined and created within the Customer Directory in the
     * Square Seller Dashboard or Point of Sale.
     *
     * @maps segment
     */
    public function setSegment(?CustomerSegment $segment): void
    {
        $this->segment = $segment;
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
            $json['errors']  = $this->errors;
        }
        if (isset($this->segment)) {
            $json['segment'] = $this->segment;
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
