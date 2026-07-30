<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * A `CatalogItemOptionValue` links an item variation to an item option as
 * an item option value. For example, a t-shirt item may offer a color option and
 * a size option. An item option value would represent each variation of t-shirt:
 * For example, "Color:Red, Size:Small" or "Color:Blue, Size:Medium".
 */
class CatalogItemOptionValueForItemVariation implements \JsonSerializable
{
    /**
     * @var array
     */
    private $itemOptionId = [];

    /**
     * @var array
     */
    private $itemOptionValueId = [];

    /**
     * Returns Item Option Id.
     * The unique id of an item option.
     */
    public function getItemOptionId(): ?string
    {
        if (count($this->itemOptionId) == 0) {
            return null;
        }
        return $this->itemOptionId['value'];
    }

    /**
     * Sets Item Option Id.
     * The unique id of an item option.
     *
     * @maps item_option_id
     */
    public function setItemOptionId(?string $itemOptionId): void
    {
        $this->itemOptionId['value'] = $itemOptionId;
    }

    /**
     * Unsets Item Option Id.
     * The unique id of an item option.
     */
    public function unsetItemOptionId(): void
    {
        $this->itemOptionId = [];
    }

    /**
     * Returns Item Option Value Id.
     * The unique id of the selected value for the item option.
     */
    public function getItemOptionValueId(): ?string
    {
        if (count($this->itemOptionValueId) == 0) {
            return null;
        }
        return $this->itemOptionValueId['value'];
    }

    /**
     * Sets Item Option Value Id.
     * The unique id of the selected value for the item option.
     *
     * @maps item_option_value_id
     */
    public function setItemOptionValueId(?string $itemOptionValueId): void
    {
        $this->itemOptionValueId['value'] = $itemOptionValueId;
    }

    /**
     * Unsets Item Option Value Id.
     * The unique id of the selected value for the item option.
     */
    public function unsetItemOptionValueId(): void
    {
        $this->itemOptionValueId = [];
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
        if (!empty($this->itemOptionId)) {
            $json['item_option_id']       = $this->itemOptionId['value'];
        }
        if (!empty($this->itemOptionValueId)) {
            $json['item_option_value_id'] = $this->itemOptionValueId['value'];
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
