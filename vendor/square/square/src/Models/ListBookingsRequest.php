<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

class ListBookingsRequest implements \JsonSerializable
{
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
    private $teamMemberId = [];

    /**
     * @var array
     */
    private $locationId = [];

    /**
     * @var array
     */
    private $startAtMin = [];

    /**
     * @var array
     */
    private $startAtMax = [];

    /**
     * Returns Limit.
     * The maximum number of results per page to return in a paged response.
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
     * The maximum number of results per page to return in a paged response.
     *
     * @maps limit
     */
    public function setLimit(?int $limit): void
    {
        $this->limit['value'] = $limit;
    }

    /**
     * Unsets Limit.
     * The maximum number of results per page to return in a paged response.
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
     * Returns Team Member Id.
     * The team member for whom to retrieve bookings. If this is not set, bookings of all members are
     * retrieved.
     */
    public function getTeamMemberId(): ?string
    {
        if (count($this->teamMemberId) == 0) {
            return null;
        }
        return $this->teamMemberId['value'];
    }

    /**
     * Sets Team Member Id.
     * The team member for whom to retrieve bookings. If this is not set, bookings of all members are
     * retrieved.
     *
     * @maps team_member_id
     */
    public function setTeamMemberId(?string $teamMemberId): void
    {
        $this->teamMemberId['value'] = $teamMemberId;
    }

    /**
     * Unsets Team Member Id.
     * The team member for whom to retrieve bookings. If this is not set, bookings of all members are
     * retrieved.
     */
    public function unsetTeamMemberId(): void
    {
        $this->teamMemberId = [];
    }

    /**
     * Returns Location Id.
     * The location for which to retrieve bookings. If this is not set, all locations' bookings are
     * retrieved.
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
     * The location for which to retrieve bookings. If this is not set, all locations' bookings are
     * retrieved.
     *
     * @maps location_id
     */
    public function setLocationId(?string $locationId): void
    {
        $this->locationId['value'] = $locationId;
    }

    /**
     * Unsets Location Id.
     * The location for which to retrieve bookings. If this is not set, all locations' bookings are
     * retrieved.
     */
    public function unsetLocationId(): void
    {
        $this->locationId = [];
    }

    /**
     * Returns Start at Min.
     * The RFC 3339 timestamp specifying the earliest of the start time. If this is not set, the current
     * time is used.
     */
    public function getStartAtMin(): ?string
    {
        if (count($this->startAtMin) == 0) {
            return null;
        }
        return $this->startAtMin['value'];
    }

    /**
     * Sets Start at Min.
     * The RFC 3339 timestamp specifying the earliest of the start time. If this is not set, the current
     * time is used.
     *
     * @maps start_at_min
     */
    public function setStartAtMin(?string $startAtMin): void
    {
        $this->startAtMin['value'] = $startAtMin;
    }

    /**
     * Unsets Start at Min.
     * The RFC 3339 timestamp specifying the earliest of the start time. If this is not set, the current
     * time is used.
     */
    public function unsetStartAtMin(): void
    {
        $this->startAtMin = [];
    }

    /**
     * Returns Start at Max.
     * The RFC 3339 timestamp specifying the latest of the start time. If this is not set, the time of 31
     * days after `start_at_min` is used.
     */
    public function getStartAtMax(): ?string
    {
        if (count($this->startAtMax) == 0) {
            return null;
        }
        return $this->startAtMax['value'];
    }

    /**
     * Sets Start at Max.
     * The RFC 3339 timestamp specifying the latest of the start time. If this is not set, the time of 31
     * days after `start_at_min` is used.
     *
     * @maps start_at_max
     */
    public function setStartAtMax(?string $startAtMax): void
    {
        $this->startAtMax['value'] = $startAtMax;
    }

    /**
     * Unsets Start at Max.
     * The RFC 3339 timestamp specifying the latest of the start time. If this is not set, the time of 31
     * days after `start_at_min` is used.
     */
    public function unsetStartAtMax(): void
    {
        $this->startAtMax = [];
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
        if (!empty($this->limit)) {
            $json['limit']          = $this->limit['value'];
        }
        if (!empty($this->cursor)) {
            $json['cursor']         = $this->cursor['value'];
        }
        if (!empty($this->teamMemberId)) {
            $json['team_member_id'] = $this->teamMemberId['value'];
        }
        if (!empty($this->locationId)) {
            $json['location_id']    = $this->locationId['value'];
        }
        if (!empty($this->startAtMin)) {
            $json['start_at_min']   = $this->startAtMin['value'];
        }
        if (!empty($this->startAtMax)) {
            $json['start_at_max']   = $this->startAtMax['value'];
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
