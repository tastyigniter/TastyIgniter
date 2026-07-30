<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

class ListTeamMemberBookingProfilesRequest implements \JsonSerializable
{
    /**
     * @var array
     */
    private $bookableOnly = [];

    /**
     * @var array
     */
    private $limit = [];

    /**
     * @var array
     */
    private $cursor = [];

    /**
     * @var array
     */
    private $locationId = [];

    /**
     * Returns Bookable Only.
     * Indicates whether to include only bookable team members in the returned result (`true`) or not
     * (`false`).
     */
    public function getBookableOnly(): ?bool
    {
        if (count($this->bookableOnly) == 0) {
            return null;
        }
        return $this->bookableOnly['value'];
    }

    /**
     * Sets Bookable Only.
     * Indicates whether to include only bookable team members in the returned result (`true`) or not
     * (`false`).
     *
     * @maps bookable_only
     */
    public function setBookableOnly(?bool $bookableOnly): void
    {
        $this->bookableOnly['value'] = $bookableOnly;
    }

    /**
     * Unsets Bookable Only.
     * Indicates whether to include only bookable team members in the returned result (`true`) or not
     * (`false`).
     */
    public function unsetBookableOnly(): void
    {
        $this->bookableOnly = [];
    }

    /**
     * Returns Limit.
     * The maximum number of results to return in a paged response.
     */
    public function getLimit(): ?int
    {
        if (count($this->limit) == 0) {
            return null;
        }
        return $this->limit['value'];
    }

    /**
     * Sets Limit.
     * The maximum number of results to return in a paged response.
     *
     * @maps limit
     */
    public function setLimit(?int $limit): void
    {
        $this->limit['value'] = $limit;
    }

    /**
     * Unsets Limit.
     * The maximum number of results to return in a paged response.
     */
    public function unsetLimit(): void
    {
        $this->limit = [];
    }

    /**
     * Returns Cursor.
     * The pagination cursor from the preceding response to return the next page of the results. Do not set
     * this when retrieving the first page of the results.
     */
    public function getCursor(): ?string
    {
        if (count($this->cursor) == 0) {
            return null;
        }
        return $this->cursor['value'];
    }

    /**
     * Sets Cursor.
     * The pagination cursor from the preceding response to return the next page of the results. Do not set
     * this when retrieving the first page of the results.
     *
     * @maps cursor
     */
    public function setCursor(?string $cursor): void
    {
        $this->cursor['value'] = $cursor;
    }

    /**
     * Unsets Cursor.
     * The pagination cursor from the preceding response to return the next page of the results. Do not set
     * this when retrieving the first page of the results.
     */
    public function unsetCursor(): void
    {
        $this->cursor = [];
    }

    /**
     * Returns Location Id.
     * Indicates whether to include only team members enabled at the given location in the returned result.
     */
    public function getLocationId(): ?string
    {
        if (count($this->locationId) == 0) {
            return null;
        }
        return $this->locationId['value'];
    }

    /**
     * Sets Location Id.
     * Indicates whether to include only team members enabled at the given location in the returned result.
     *
     * @maps location_id
     */
    public function setLocationId(?string $locationId): void
    {
        $this->locationId['value'] = $locationId;
    }

    /**
     * Unsets Location Id.
     * Indicates whether to include only team members enabled at the given location in the returned result.
     */
    public function unsetLocationId(): void
    {
        $this->locationId = [];
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
        if (!empty($this->bookableOnly)) {
            $json['bookable_only'] = $this->bookableOnly['value'];
        }
        if (!empty($this->limit)) {
            $json['limit']         = $this->limit['value'];
        }
        if (!empty($this->cursor)) {
            $json['cursor']        = $this->cursor['value'];
        }
        if (!empty($this->locationId)) {
            $json['location_id']   = $this->locationId['value'];
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
