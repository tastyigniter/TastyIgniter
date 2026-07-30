<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Represents the rule of conversion between a stockable
 * [CatalogItemVariation]($m/CatalogItemVariation)
 * and a non-stockable sell-by or receive-by `CatalogItemVariation` that
 * share the same underlying stock.
 */
class CatalogStockConversion implements \JsonSerializable
{
    /**
     * @var string
     */
    private $stockableItemVariationId;

    /**
     * @var string
     */
    private $stockableQuantity;

    /**
     * @var string
     */
    private $nonstockableQuantity;

    /**
     * @param string $stockableItemVariationId
     * @param string $stockableQuantity
     * @param string $nonstockableQuantity
     */
    public function __construct(
        string $stockableItemVariationId,
        string $stockableQuantity,
        string $nonstockableQuantity
    ) {
        $this->stockableItemVariationId = $stockableItemVariationId;
        $this->stockableQuantity = $stockableQuantity;
        $this->nonstockableQuantity = $nonstockableQuantity;
    }

    /**
     * Returns Stockable Item Variation Id.
     * References to the stockable [CatalogItemVariation](entity:CatalogItemVariation)
     * for this stock conversion. Selling, receiving or recounting the non-stockable
     * `CatalogItemVariation`
     * defined with a stock conversion results in adjustments of this stockable `CatalogItemVariation`.
     * This immutable field must reference a stockable `CatalogItemVariation`
     * that shares the parent [CatalogItem](entity:CatalogItem) of the converted `CatalogItemVariation.`
     */
    public function getStockableItemVariationId(): string
    {
        return $this->stockableItemVariationId;
    }

    /**
     * Sets Stockable Item Variation Id.
     * References to the stockable [CatalogItemVariation](entity:CatalogItemVariation)
     * for this stock conversion. Selling, receiving or recounting the non-stockable
     * `CatalogItemVariation`
     * defined with a stock conversion results in adjustments of this stockable `CatalogItemVariation`.
     * This immutable field must reference a stockable `CatalogItemVariation`
     * that shares the parent [CatalogItem](entity:CatalogItem) of the converted `CatalogItemVariation.`
     *
     * @required
     * @maps stockable_item_variation_id
     */
    public function setStockableItemVariationId(string $stockableItemVariationId): void
    {
        $this->stockableItemVariationId = $stockableItemVariationId;
    }

    /**
     * Returns Stockable Quantity.
     * The quantity of the stockable item variation (as identified by `stockable_item_variation_id`)
     * equivalent to the non-stockable item variation quantity (as specified in `nonstockable_quantity`)
     * as defined by this stock conversion.  It accepts a decimal number in a string format that can take
     * up to 10 digits before the decimal point and up to 5 digits after the decimal point.
     */
    public function getStockableQuantity(): string
    {
        return $this->stockableQuantity;
    }

    /**
     * Sets Stockable Quantity.
     * The quantity of the stockable item variation (as identified by `stockable_item_variation_id`)
     * equivalent to the non-stockable item variation quantity (as specified in `nonstockable_quantity`)
     * as defined by this stock conversion.  It accepts a decimal number in a string format that can take
     * up to 10 digits before the decimal point and up to 5 digits after the decimal point.
     *
     * @required
     * @maps stockable_quantity
     */
    public function setStockableQuantity(string $stockableQuantity): void
    {
        $this->stockableQuantity = $stockableQuantity;
    }

    /**
     * Returns Nonstockable Quantity.
     * The converted equivalent quantity of the non-stockable [CatalogItemVariation](entity:
     * CatalogItemVariation)
     * in its measurement unit. The `stockable_quantity` value and this `nonstockable_quantity` value
     * together
     * define the conversion ratio between stockable item variation and the non-stockable item variation.
     * It accepts a decimal number in a string format that can take up to 10 digits before the decimal
     * point
     * and up to 5 digits after the decimal point.
     */
    public function getNonstockableQuantity(): string
    {
        return $this->nonstockableQuantity;
    }

    /**
     * Sets Nonstockable Quantity.
     * The converted equivalent quantity of the non-stockable [CatalogItemVariation](entity:
     * CatalogItemVariation)
     * in its measurement unit. The `stockable_quantity` value and this `nonstockable_quantity` value
     * together
     * define the conversion ratio between stockable item variation and the non-stockable item variation.
     * It accepts a decimal number in a string format that can take up to 10 digits before the decimal
     * point
     * and up to 5 digits after the decimal point.
     *
     * @required
     * @maps nonstockable_quantity
     */
    public function setNonstockableQuantity(string $nonstockableQuantity): void
    {
        $this->nonstockableQuantity = $nonstockableQuantity;
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
        $json['stockable_item_variation_id'] = $this->stockableItemVariationId;
        $json['stockable_quantity']          = $this->stockableQuantity;
        $json['nonstockable_quantity']       = $this->nonstockableQuantity;
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
