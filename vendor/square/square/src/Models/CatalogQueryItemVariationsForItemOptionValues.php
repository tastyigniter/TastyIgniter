<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * The query filter to return the item variations containing the specified item option value IDs.
 */
class CatalogQueryItemVariationsForItemOptionValues implements \JsonSerializable
{
    /**
     * @var array
     */
    private $itemOptionValueIds = [];

    /**
     * Returns Item Option Value Ids.
     * A set of `CatalogItemOptionValue` IDs to be used to find associated
     * `CatalogItemVariation`s. All ItemVariations that contain all of the given
     * Item Option Values (in any order) will be returned.
     *
     * @return string[]|null
     */
    public function getItemOptionValueIds(): ?array
    {
        if (count($this->itemOptionValueIds) == 0) {
            return null;
        }
        return $this->itemOptionValueIds['value'];
    }

    /**
     * Sets Item Option Value Ids.
     * A set of `CatalogItemOptionValue` IDs to be used to find associated
     * `CatalogItemVariation`s. All ItemVariations that contain all of the given
     * Item Option Values (in any order) will be returned.
     *
     * @maps item_option_value_ids
     *
     * @param string[]|null $itemOptionValueIds
     */
    public function setItemOptionValueIds(?array $itemOptionValueIds): void
    {
        $this->itemOptionValueIds['value'] = $itemOptionValueIds;
    }

    /**
     * Unsets Item Option Value Ids.
     * A set of `CatalogItemOptionValue` IDs to be used to find associated
     * `CatalogItemVariation`s. All ItemVariations that contain all of the given
     * Item Option Values (in any order) will be returned.
     */
    public function unsetItemOptionValueIds(): void
    {
        $this->itemOptionValueIds = [];
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
        if (!empty($this->itemOptionValueIds)) {
            $json['item_option_value_ids'] = $this->itemOptionValueIds['value'];
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
