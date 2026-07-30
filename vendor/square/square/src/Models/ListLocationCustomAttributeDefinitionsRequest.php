<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Represents a
 * [ListLocationCustomAttributeDefinitions]($e/LocationCustomAttributes/ListLocationCustomAttributeDefi
 * nitions) request.
 */
class ListLocationCustomAttributeDefinitionsRequest implements \JsonSerializable
{
    /**
     * @var string|null
     */
    private $visibilityFilter;

    /**
     * @var array
     */
    private $limit = [];

    /**
     * @var array
     */
    private $cursor = [];

    /**
     * Returns Visibility Filter.
     * Enumeration of visibility-filter values used to set the ability to view custom attributes or custom
     * attribute definitions.
     */
    public function getVisibilityFilter(): ?string
    {
        return $this->visibilityFilter;
    }

    /**
     * Sets Visibility Filter.
     * Enumeration of visibility-filter values used to set the ability to view custom attributes or custom
     * attribute definitions.
     *
     * @maps visibility_filter
     */
    public function setVisibilityFilter(?string $visibilityFilter): void
    {
        $this->visibilityFilter = $visibilityFilter;
    }

    /**
     * Returns Limit.
     * The maximum number of results to return in a single paged response. This limit is advisory.
     * The response might contain more or fewer results. The minimum value is 1 and the maximum value is
     * 100.
     * The default value is 20. For more information, see [Pagination](https://developer.squareup.
     * com/docs/build-basics/common-api-patterns/pagination).
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
     * The maximum number of results to return in a single paged response. This limit is advisory.
     * The response might contain more or fewer results. The minimum value is 1 and the maximum value is
     * 100.
     * The default value is 20. For more information, see [Pagination](https://developer.squareup.
     * com/docs/build-basics/common-api-patterns/pagination).
     *
     * @maps limit
     */
    public function setLimit(?int $limit): void
    {
        $this->limit['value'] = $limit;
    }

    /**
     * Unsets Limit.
     * The maximum number of results to return in a single paged response. This limit is advisory.
     * The response might contain more or fewer results. The minimum value is 1 and the maximum value is
     * 100.
     * The default value is 20. For more information, see [Pagination](https://developer.squareup.
     * com/docs/build-basics/common-api-patterns/pagination).
     */
    public function unsetLimit(): void
    {
        $this->limit = [];
    }

    /**
     * Returns Cursor.
     * The cursor returned in the paged response from the previous call to this endpoint.
     * Provide this cursor to retrieve the next page of results for your original request.
     * For more information, see [Pagination](https://developer.squareup.com/docs/build-basics/common-api-
     * patterns/pagination).
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
     * The cursor returned in the paged response from the previous call to this endpoint.
     * Provide this cursor to retrieve the next page of results for your original request.
     * For more information, see [Pagination](https://developer.squareup.com/docs/build-basics/common-api-
     * patterns/pagination).
     *
     * @maps cursor
     */
    public function setCursor(?string $cursor): void
    {
        $this->cursor['value'] = $cursor;
    }

    /**
     * Unsets Cursor.
     * The cursor returned in the paged response from the previous call to this endpoint.
     * Provide this cursor to retrieve the next page of results for your original request.
     * For more information, see [Pagination](https://developer.squareup.com/docs/build-basics/common-api-
     * patterns/pagination).
     */
    public function unsetCursor(): void
    {
        $this->cursor = [];
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
        if (isset($this->visibilityFilter)) {
            $json['visibility_filter'] = $this->visibilityFilter;
        }
        if (!empty($this->limit)) {
            $json['limit']             = $this->limit['value'];
        }
        if (!empty($this->cursor)) {
            $json['cursor']            = $this->cursor['value'];
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
