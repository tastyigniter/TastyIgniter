<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Filter events by date time range.
 */
class LoyaltyEventDateTimeFilter implements \JsonSerializable
{
    /**
     * @var TimeRange
     */
    private $createdAt;

    /**
     * @param TimeRange $createdAt
     */
    public function __construct(TimeRange $createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * Returns Created At.
     * Represents a generic time range. The start and end values are
     * represented in RFC 3339 format. Time ranges are customized to be
     * inclusive or exclusive based on the needs of a particular endpoint.
     * Refer to the relevant endpoint-specific documentation to determine
     * how time ranges are handled.
     */
    public function getCreatedAt(): TimeRange
    {
        return $this->createdAt;
    }

    /**
     * Sets Created At.
     * Represents a generic time range. The start and end values are
     * represented in RFC 3339 format. Time ranges are customized to be
     * inclusive or exclusive based on the needs of a particular endpoint.
     * Refer to the relevant endpoint-specific documentation to determine
     * how time ranges are handled.
     *
     * @required
     * @maps created_at
     */
    public function setCreatedAt(TimeRange $createdAt): void
    {
        $this->createdAt = $createdAt;
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
        $json['created_at'] = $this->createdAt;
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
