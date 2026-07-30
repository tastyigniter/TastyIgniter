<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

class BatchRetrieveInventoryChangesRequest implements \JsonSerializable
{
    /**
     * @var array
     */
    private $catalogObjectIds = [];

    /**
     * @var array
     */
    private $locationIds = [];

    /**
     * @var array
     */
    private $types = [];

    /**
     * @var array
     */
    private $states = [];

    /**
     * @var array
     */
    private $updatedAfter = [];

    /**
     * @var array
     */
    private $updatedBefore = [];

    /**
     * @var array
     */
    private $cursor = [];

    /**
     * @var array
     */
    private $limit = [];

    /**
     * Returns Catalog Object Ids.
     * The filter to return results by `CatalogObject` ID.
     * The filter is only applicable when set. The default value is null.
     *
     * @return string[]|null
     */
    public function getCatalogObjectIds(): ?array
    {
        if (count($this->catalogObjectIds) == 0) {
            return null;
        }
        return $this->catalogObjectIds['value'];
    }

    /**
     * Sets Catalog Object Ids.
     * The filter to return results by `CatalogObject` ID.
     * The filter is only applicable when set. The default value is null.
     *
     * @maps catalog_object_ids
     *
     * @param string[]|null $catalogObjectIds
     */
    public function setCatalogObjectIds(?array $catalogObjectIds): void
    {
        $this->catalogObjectIds['value'] = $catalogObjectIds;
    }

    /**
     * Unsets Catalog Object Ids.
     * The filter to return results by `CatalogObject` ID.
     * The filter is only applicable when set. The default value is null.
     */
    public function unsetCatalogObjectIds(): void
    {
        $this->catalogObjectIds = [];
    }

    /**
     * Returns Location Ids.
     * The filter to return results by `Location` ID.
     * The filter is only applicable when set. The default value is null.
     *
     * @return string[]|null
     */
    public function getLocationIds(): ?array
    {
        if (count($this->locationIds) == 0) {
            return null;
        }
        return $this->locationIds['value'];
    }

    /**
     * Sets Location Ids.
     * The filter to return results by `Location` ID.
     * The filter is only applicable when set. The default value is null.
     *
     * @maps location_ids
     *
     * @param string[]|null $locationIds
     */
    public function setLocationIds(?array $locationIds): void
    {
        $this->locationIds['value'] = $locationIds;
    }

    /**
     * Unsets Location Ids.
     * The filter to return results by `Location` ID.
     * The filter is only applicable when set. The default value is null.
     */
    public function unsetLocationIds(): void
    {
        $this->locationIds = [];
    }

    /**
     * Returns Types.
     * The filter to return results by `InventoryChangeType` values other than `TRANSFER`.
     * The default value is `[PHYSICAL_COUNT, ADJUSTMENT]`.
     *
     * @return string[]|null
     */
    public function getTypes(): ?array
    {
        if (count($this->types) == 0) {
            return null;
        }
        return $this->types['value'];
    }

    /**
     * Sets Types.
     * The filter to return results by `InventoryChangeType` values other than `TRANSFER`.
     * The default value is `[PHYSICAL_COUNT, ADJUSTMENT]`.
     *
     * @maps types
     *
     * @param string[]|null $types
     */
    public function setTypes(?array $types): void
    {
        $this->types['value'] = $types;
    }

    /**
     * Unsets Types.
     * The filter to return results by `InventoryChangeType` values other than `TRANSFER`.
     * The default value is `[PHYSICAL_COUNT, ADJUSTMENT]`.
     */
    public function unsetTypes(): void
    {
        $this->types = [];
    }

    /**
     * Returns States.
     * The filter to return `ADJUSTMENT` query results by
     * `InventoryState`. This filter is only applied when set.
     * The default value is null.
     *
     * @return string[]|null
     */
    public function getStates(): ?array
    {
        if (count($this->states) == 0) {
            return null;
        }
        return $this->states['value'];
    }

    /**
     * Sets States.
     * The filter to return `ADJUSTMENT` query results by
     * `InventoryState`. This filter is only applied when set.
     * The default value is null.
     *
     * @maps states
     *
     * @param string[]|null $states
     */
    public function setStates(?array $states): void
    {
        $this->states['value'] = $states;
    }

    /**
     * Unsets States.
     * The filter to return `ADJUSTMENT` query results by
     * `InventoryState`. This filter is only applied when set.
     * The default value is null.
     */
    public function unsetStates(): void
    {
        $this->states = [];
    }

    /**
     * Returns Updated After.
     * The filter to return results with their `calculated_at` value
     * after the given time as specified in an RFC 3339 timestamp.
     * The default value is the UNIX epoch of (`1970-01-01T00:00:00Z`).
     */
    public function getUpdatedAfter(): ?string
    {
        if (count($this->updatedAfter) == 0) {
            return null;
        }
        return $this->updatedAfter['value'];
    }

    /**
     * Sets Updated After.
     * The filter to return results with their `calculated_at` value
     * after the given time as specified in an RFC 3339 timestamp.
     * The default value is the UNIX epoch of (`1970-01-01T00:00:00Z`).
     *
     * @maps updated_after
     */
    public function setUpdatedAfter(?string $updatedAfter): void
    {
        $this->updatedAfter['value'] = $updatedAfter;
    }

    /**
     * Unsets Updated After.
     * The filter to return results with their `calculated_at` value
     * after the given time as specified in an RFC 3339 timestamp.
     * The default value is the UNIX epoch of (`1970-01-01T00:00:00Z`).
     */
    public function unsetUpdatedAfter(): void
    {
        $this->updatedAfter = [];
    }

    /**
     * Returns Updated Before.
     * The filter to return results with their `created_at` or `calculated_at` value
     * strictly before the given time as specified in an RFC 3339 timestamp.
     * The default value is the UNIX epoch of (`1970-01-01T00:00:00Z`).
     */
    public function getUpdatedBefore(): ?string
    {
        if (count($this->updatedBefore) == 0) {
            return null;
        }
        return $this->updatedBefore['value'];
    }

    /**
     * Sets Updated Before.
     * The filter to return results with their `created_at` or `calculated_at` value
     * strictly before the given time as specified in an RFC 3339 timestamp.
     * The default value is the UNIX epoch of (`1970-01-01T00:00:00Z`).
     *
     * @maps updated_before
     */
    public function setUpdatedBefore(?string $updatedBefore): void
    {
        $this->updatedBefore['value'] = $updatedBefore;
    }

    /**
     * Unsets Updated Before.
     * The filter to return results with their `created_at` or `calculated_at` value
     * strictly before the given time as specified in an RFC 3339 timestamp.
     * The default value is the UNIX epoch of (`1970-01-01T00:00:00Z`).
     */
    public function unsetUpdatedBefore(): void
    {
        $this->updatedBefore = [];
    }

    /**
     * Returns Cursor.
     * A pagination cursor returned by a previous call to this endpoint.
     * Provide this to retrieve the next set of results for the original query.
     *
     * See the [Pagination](https://developer.squareup.com/docs/working-with-apis/pagination) guide for
     * more information.
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
     * A pagination cursor returned by a previous call to this endpoint.
     * Provide this to retrieve the next set of results for the original query.
     *
     * See the [Pagination](https://developer.squareup.com/docs/working-with-apis/pagination) guide for
     * more information.
     *
     * @maps cursor
     */
    public function setCursor(?string $cursor): void
    {
        $this->cursor['value'] = $cursor;
    }

    /**
     * Unsets Cursor.
     * A pagination cursor returned by a previous call to this endpoint.
     * Provide this to retrieve the next set of results for the original query.
     *
     * See the [Pagination](https://developer.squareup.com/docs/working-with-apis/pagination) guide for
     * more information.
     */
    public function unsetCursor(): void
    {
        $this->cursor = [];
    }

    /**
     * Returns Limit.
     * The number of [records](entity:InventoryChange) to return.
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
     * The number of [records](entity:InventoryChange) to return.
     *
     * @maps limit
     */
    public function setLimit(?int $limit): void
    {
        $this->limit['value'] = $limit;
    }

    /**
     * Unsets Limit.
     * The number of [records](entity:InventoryChange) to return.
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
        if (!empty($this->catalogObjectIds)) {
            $json['catalog_object_ids'] = $this->catalogObjectIds['value'];
        }
        if (!empty($this->locationIds)) {
            $json['location_ids']       = $this->locationIds['value'];
        }
        if (!empty($this->types)) {
            $json['types']              = $this->types['value'];
        }
        if (!empty($this->states)) {
            $json['states']             = $this->states['value'];
        }
        if (!empty($this->updatedAfter)) {
            $json['updated_after']      = $this->updatedAfter['value'];
        }
        if (!empty($this->updatedBefore)) {
            $json['updated_before']     = $this->updatedBefore['value'];
        }
        if (!empty($this->cursor)) {
            $json['cursor']             = $this->cursor['value'];
        }
        if (!empty($this->limit)) {
            $json['limit']              = $this->limit['value'];
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
