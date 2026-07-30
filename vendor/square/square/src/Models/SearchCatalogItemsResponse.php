<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Defines the response body returned from the [SearchCatalogItems]($e/Catalog/SearchCatalogItems)
 * endpoint.
 */
class SearchCatalogItemsResponse implements \JsonSerializable
{
    /**
     * @var Error[]|null
     */
    private $errors;

    /**
     * @var CatalogObject[]|null
     */
    private $items;

    /**
     * @var string|null
     */
    private $cursor;

    /**
     * @var string[]|null
     */
    private $matchedVariationIds;

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
     * Returns Items.
     * Returned items matching the specified query expressions.
     *
     * @return CatalogObject[]|null
     */
    public function getItems(): ?array
    {
        return $this->items;
    }

    /**
     * Sets Items.
     * Returned items matching the specified query expressions.
     *
     * @maps items
     *
     * @param CatalogObject[]|null $items
     */
    public function setItems(?array $items): void
    {
        $this->items = $items;
    }

    /**
     * Returns Cursor.
     * Pagination token used in the next request to return more of the search result.
     */
    public function getCursor(): ?string
    {
        return $this->cursor;
    }

    /**
     * Sets Cursor.
     * Pagination token used in the next request to return more of the search result.
     *
     * @maps cursor
     */
    public function setCursor(?string $cursor): void
    {
        $this->cursor = $cursor;
    }

    /**
     * Returns Matched Variation Ids.
     * Ids of returned item variations matching the specified query expression.
     *
     * @return string[]|null
     */
    public function getMatchedVariationIds(): ?array
    {
        return $this->matchedVariationIds;
    }

    /**
     * Sets Matched Variation Ids.
     * Ids of returned item variations matching the specified query expression.
     *
     * @maps matched_variation_ids
     *
     * @param string[]|null $matchedVariationIds
     */
    public function setMatchedVariationIds(?array $matchedVariationIds): void
    {
        $this->matchedVariationIds = $matchedVariationIds;
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
            $json['errors']                = $this->errors;
        }
        if (isset($this->items)) {
            $json['items']                 = $this->items;
        }
        if (isset($this->cursor)) {
            $json['cursor']                = $this->cursor;
        }
        if (isset($this->matchedVariationIds)) {
            $json['matched_variation_ids'] = $this->matchedVariationIds;
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
