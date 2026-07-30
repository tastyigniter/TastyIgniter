<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * V1PaymentItemDetail
 */
class V1PaymentItemDetail implements \JsonSerializable
{
    /**
     * @var array
     */
    private $categoryName = [];

    /**
     * @var array
     */
    private $sku = [];

    /**
     * @var array
     */
    private $itemId = [];

    /**
     * @var array
     */
    private $itemVariationId = [];

    /**
     * Returns Category Name.
     * The name of the item's merchant-defined category, if any.
     */
    public function getCategoryName(): ?string
    {
        if (count($this->categoryName) == 0) {
            return null;
        }
        return $this->categoryName['value'];
    }

    /**
     * Sets Category Name.
     * The name of the item's merchant-defined category, if any.
     *
     * @maps category_name
     */
    public function setCategoryName(?string $categoryName): void
    {
        $this->categoryName['value'] = $categoryName;
    }

    /**
     * Unsets Category Name.
     * The name of the item's merchant-defined category, if any.
     */
    public function unsetCategoryName(): void
    {
        $this->categoryName = [];
    }

    /**
     * Returns Sku.
     * The item's merchant-defined SKU, if any.
     */
    public function getSku(): ?string
    {
        if (count($this->sku) == 0) {
            return null;
        }
        return $this->sku['value'];
    }

    /**
     * Sets Sku.
     * The item's merchant-defined SKU, if any.
     *
     * @maps sku
     */
    public function setSku(?string $sku): void
    {
        $this->sku['value'] = $sku;
    }

    /**
     * Unsets Sku.
     * The item's merchant-defined SKU, if any.
     */
    public function unsetSku(): void
    {
        $this->sku = [];
    }

    /**
     * Returns Item Id.
     * The unique ID of the item purchased, if any.
     */
    public function getItemId(): ?string
    {
        if (count($this->itemId) == 0) {
            return null;
        }
        return $this->itemId['value'];
    }

    /**
     * Sets Item Id.
     * The unique ID of the item purchased, if any.
     *
     * @maps item_id
     */
    public function setItemId(?string $itemId): void
    {
        $this->itemId['value'] = $itemId;
    }

    /**
     * Unsets Item Id.
     * The unique ID of the item purchased, if any.
     */
    public function unsetItemId(): void
    {
        $this->itemId = [];
    }

    /**
     * Returns Item Variation Id.
     * The unique ID of the item variation purchased, if any.
     */
    public function getItemVariationId(): ?string
    {
        if (count($this->itemVariationId) == 0) {
            return null;
        }
        return $this->itemVariationId['value'];
    }

    /**
     * Sets Item Variation Id.
     * The unique ID of the item variation purchased, if any.
     *
     * @maps item_variation_id
     */
    public function setItemVariationId(?string $itemVariationId): void
    {
        $this->itemVariationId['value'] = $itemVariationId;
    }

    /**
     * Unsets Item Variation Id.
     * The unique ID of the item variation purchased, if any.
     */
    public function unsetItemVariationId(): void
    {
        $this->itemVariationId = [];
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
        if (!empty($this->categoryName)) {
            $json['category_name']     = $this->categoryName['value'];
        }
        if (!empty($this->sku)) {
            $json['sku']               = $this->sku['value'];
        }
        if (!empty($this->itemId)) {
            $json['item_id']           = $this->itemId['value'];
        }
        if (!empty($this->itemVariationId)) {
            $json['item_variation_id'] = $this->itemVariationId['value'];
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
