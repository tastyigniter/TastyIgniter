<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Defines input parameters in a request to the
 * [ListSubscriptionEvents]($e/Subscriptions/ListSubscriptionEvents)
 * endpoint.
 */
class ListSubscriptionEventsRequest implements \JsonSerializable
{
    /**
     * @var array
     */
    private $cursor = [];

    /**
     * @var array
     */
    private $limit = [];

    /**
     * Returns Cursor.
     * When the total number of resulting subscription events exceeds the limit of a paged response,
     * specify the cursor returned from a preceding response here to fetch the next set of results.
     * If the cursor is unset, the response contains the last page of the results.
     *
     * For more information, see [Pagination](https://developer.squareup.com/docs/working-with-
     * apis/pagination).
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
     * When the total number of resulting subscription events exceeds the limit of a paged response,
     * specify the cursor returned from a preceding response here to fetch the next set of results.
     * If the cursor is unset, the response contains the last page of the results.
     *
     * For more information, see [Pagination](https://developer.squareup.com/docs/working-with-
     * apis/pagination).
     *
     * @maps cursor
     */
    public function setCursor(?string $cursor): void
    {
        $this->cursor['value'] = $cursor;
    }

    /**
     * Unsets Cursor.
     * When the total number of resulting subscription events exceeds the limit of a paged response,
     * specify the cursor returned from a preceding response here to fetch the next set of results.
     * If the cursor is unset, the response contains the last page of the results.
     *
     * For more information, see [Pagination](https://developer.squareup.com/docs/working-with-
     * apis/pagination).
     */
    public function unsetCursor(): void
    {
        $this->cursor = [];
    }

    /**
     * Returns Limit.
     * The upper limit on the number of subscription events to return
     * in a paged response.
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
     * The upper limit on the number of subscription events to return
     * in a paged response.
     *
     * @maps limit
     */
    public function setLimit(?int $limit): void
    {
        $this->limit['value'] = $limit;
    }

    /**
     * Unsets Limit.
     * The upper limit on the number of subscription events to return
     * in a paged response.
     */
    public function unsetLimit(): void
    {
        $this->limit = [];
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
        if (!empty($this->cursor)) {
            $json['cursor'] = $this->cursor['value'];
        }
        if (!empty($this->limit)) {
            $json['limit']  = $this->limit['value'];
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
