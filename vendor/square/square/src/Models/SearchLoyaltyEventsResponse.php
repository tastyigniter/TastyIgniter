<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * A response that contains loyalty events that satisfy the search
 * criteria, in order by the `created_at` date.
 */
class SearchLoyaltyEventsResponse implements \JsonSerializable
{
    /**
     * @var Error[]|null
     */
    private $errors;

    /**
     * @var LoyaltyEvent[]|null
     */
    private $events;

    /**
     * @var string|null
     */
    private $cursor;

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
     * Returns Events.
     * The loyalty events that satisfy the search criteria.
     *
     * @return LoyaltyEvent[]|null
     */
    public function getEvents(): ?array
    {
        return $this->events;
    }

    /**
     * Sets Events.
     * The loyalty events that satisfy the search criteria.
     *
     * @maps events
     *
     * @param LoyaltyEvent[]|null $events
     */
    public function setEvents(?array $events): void
    {
        $this->events = $events;
    }

    /**
     * Returns Cursor.
     * The pagination cursor to be used in a subsequent
     * request. If empty, this is the final response.
     * For more information,
     * see [Pagination](https://developer.squareup.com/docs/build-basics/common-api-patterns/pagination).
     */
    public function getCursor(): ?string
    {
        return $this->cursor;
    }

    /**
     * Sets Cursor.
     * The pagination cursor to be used in a subsequent
     * request. If empty, this is the final response.
     * For more information,
     * see [Pagination](https://developer.squareup.com/docs/build-basics/common-api-patterns/pagination).
     *
     * @maps cursor
     */
    public function setCursor(?string $cursor): void
    {
        $this->cursor = $cursor;
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
            $json['errors'] = $this->errors;
        }
        if (isset($this->events)) {
            $json['events'] = $this->events;
        }
        if (isset($this->cursor)) {
            $json['cursor'] = $this->cursor;
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
