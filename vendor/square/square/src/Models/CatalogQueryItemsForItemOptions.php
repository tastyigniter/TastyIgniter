<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * The query filter to return the items containing the specified item option IDs.
 */
class CatalogQueryItemsForItemOptions implements \JsonSerializable
{
    /**
     * @var array
     */
    private $itemOptionIds = [];

    /**
     * Returns Item Option Ids.
     * A set of `CatalogItemOption` IDs to be used to find associated
     * `CatalogItem`s. All Items that contain all of the given Item Options (in any order)
     * will be returned.
     *
     * @return string[]|null
     */
    public function getItemOptionIds(): ?array
    {
        if (count($this->itemOptionIds) == 0) {
            return null;
        }
        return $this->itemOptionIds['value'];
    }

    /**
     * Sets Item Option Ids.
     * A set of `CatalogItemOption` IDs to be used to find associated
     * `CatalogItem`s. All Items that contain all of the given Item Options (in any order)
     * will be returned.
     *
     * @maps item_option_ids
     *
     * @param string[]|null $itemOptionIds
     */
    public function setItemOptionIds(?array $itemOptionIds): void
    {
        $this->itemOptionIds['value'] = $itemOptionIds;
    }

    /**
     * Unsets Item Option Ids.
     * A set of `CatalogItemOption` IDs to be used to find associated
     * `CatalogItem`s. All Items that contain all of the given Item Options (in any order)
     * will be returned.
     */
    public function unsetItemOptionIds(): void
    {
        $this->itemOptionIds = [];
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
        if (!empty($this->itemOptionIds)) {
            $json['item_option_ids'] = $this->itemOptionIds['value'];
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
