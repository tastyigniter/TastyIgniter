<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Represents Square-estimated quantity of items in a particular state at a
 * particular seller location based on the known history of physical counts and
 * inventory adjustments.
 */
class InventoryCount implements \JsonSerializable
{
    /**
     * @var array
     */
    private $catalogObjectId = [];

    /**
     * @var array
     */
    private $catalogObjectType = [];

    /**
     * @var string|null
     */
    private $state;

    /**
     * @var array
     */
    private $locationId = [];

    /**
     * @var array
     */
    private $quantity = [];

    /**
     * @var string|null
     */
    private $calculatedAt;

    /**
     * @var bool|null
     */
    private $isEstimated;

    /**
     * Returns Catalog Object Id.
     * The Square-generated ID of the
     * [CatalogObject](entity:CatalogObject) being tracked.
     */
    public function getCatalogObjectId(): ?string
    {
        if (count($this->catalogObjectId) == 0) {
            return null;
        }
        return $this->catalogObjectId['value'];
    }

    /**
     * Sets Catalog Object Id.
     * The Square-generated ID of the
     * [CatalogObject](entity:CatalogObject) being tracked.
     *
     * @maps catalog_object_id
     */
    public function setCatalogObjectId(?string $catalogObjectId): void
    {
        $this->catalogObjectId['value'] = $catalogObjectId;
    }

    /**
     * Unsets Catalog Object Id.
     * The Square-generated ID of the
     * [CatalogObject](entity:CatalogObject) being tracked.
     */
    public function unsetCatalogObjectId(): void
    {
        $this->catalogObjectId = [];
    }

    /**
     * Returns Catalog Object Type.
     * The [type](entity:CatalogObjectType) of the [CatalogObject](entity:CatalogObject) being tracked.
     *
     * The Inventory API supports setting and reading the `"catalog_object_type": "ITEM_VARIATION"` field
     * value.
     * In addition, it can also read the `"catalog_object_type": "ITEM"` field value that is set by the
     * Square Restaurants app.
     */
    public function getCatalogObjectType(): ?string
    {
        if (count($this->catalogObjectType) == 0) {
            return null;
        }
        return $this->catalogObjectType['value'];
    }

    /**
     * Sets Catalog Object Type.
     * The [type](entity:CatalogObjectType) of the [CatalogObject](entity:CatalogObject) being tracked.
     *
     * The Inventory API supports setting and reading the `"catalog_object_type": "ITEM_VARIATION"` field
     * value.
     * In addition, it can also read the `"catalog_object_type": "ITEM"` field value that is set by the
     * Square Restaurants app.
     *
     * @maps catalog_object_type
     */
    public function setCatalogObjectType(?string $catalogObjectType): void
    {
        $this->catalogObjectType['value'] = $catalogObjectType;
    }

    /**
     * Unsets Catalog Object Type.
     * The [type](entity:CatalogObjectType) of the [CatalogObject](entity:CatalogObject) being tracked.
     *
     * The Inventory API supports setting and reading the `"catalog_object_type": "ITEM_VARIATION"` field
     * value.
     * In addition, it can also read the `"catalog_object_type": "ITEM"` field value that is set by the
     * Square Restaurants app.
     */
    public function unsetCatalogObjectType(): void
    {
        $this->catalogObjectType = [];
    }

    /**
     * Returns State.
     * Indicates the state of a tracked item quantity in the lifecycle of goods.
     */
    public function getState(): ?string
    {
        return $this->state;
    }

    /**
     * Sets State.
     * Indicates the state of a tracked item quantity in the lifecycle of goods.
     *
     * @maps state
     */
    public function setState(?string $state): void
    {
        $this->state = $state;
    }

    /**
     * Returns Location Id.
     * The Square-generated ID of the [Location](entity:Location) where the related
     * quantity of items is being tracked.
     */
    public function getLocationId(): ?string
    {
        if (count($this->locationId) == 0) {
            return null;
        }
        return $this->locationId['value'];
    }

    /**
     * Sets Location Id.
     * The Square-generated ID of the [Location](entity:Location) where the related
     * quantity of items is being tracked.
     *
     * @maps location_id
     */
    public function setLocationId(?string $locationId): void
    {
        $this->locationId['value'] = $locationId;
    }

    /**
     * Unsets Location Id.
     * The Square-generated ID of the [Location](entity:Location) where the related
     * quantity of items is being tracked.
     */
    public function unsetLocationId(): void
    {
        $this->locationId = [];
    }

    /**
     * Returns Quantity.
     * The number of items affected by the estimated count as a decimal string.
     * Can support up to 5 digits after the decimal point.
     */
    public function getQuantity(): ?string
    {
        if (count($this->quantity) == 0) {
            return null;
        }
        return $this->quantity['value'];
    }

    /**
     * Sets Quantity.
     * The number of items affected by the estimated count as a decimal string.
     * Can support up to 5 digits after the decimal point.
     *
     * @maps quantity
     */
    public function setQuantity(?string $quantity): void
    {
        $this->quantity['value'] = $quantity;
    }

    /**
     * Unsets Quantity.
     * The number of items affected by the estimated count as a decimal string.
     * Can support up to 5 digits after the decimal point.
     */
    public function unsetQuantity(): void
    {
        $this->quantity = [];
    }

    /**
     * Returns Calculated At.
     * An RFC 3339-formatted timestamp that indicates when the most recent physical count or adjustment
     * affecting
     * the estimated count is received.
     */
    public function getCalculatedAt(): ?string
    {
        return $this->calculatedAt;
    }

    /**
     * Sets Calculated At.
     * An RFC 3339-formatted timestamp that indicates when the most recent physical count or adjustment
     * affecting
     * the estimated count is received.
     *
     * @maps calculated_at
     */
    public function setCalculatedAt(?string $calculatedAt): void
    {
        $this->calculatedAt = $calculatedAt;
    }

    /**
     * Returns Is Estimated.
     * Whether the inventory count is for composed variation (TRUE) or not (FALSE). If true, the inventory
     * count will not be present in the response of
     * any of these endpoints: [BatchChangeInventory]($e/Inventory/BatchChangeInventory),
     * [BatchRetrieveInventoryChanges]($e/Inventory/BatchRetrieveInventoryChanges),
     * [BatchRetrieveInventoryCounts]($e/Inventory/BatchRetrieveInventoryCounts), and
     * [RetrieveInventoryChanges]($e/Inventory/RetrieveInventoryChanges).
     */
    public function getIsEstimated(): ?bool
    {
        return $this->isEstimated;
    }

    /**
     * Sets Is Estimated.
     * Whether the inventory count is for composed variation (TRUE) or not (FALSE). If true, the inventory
     * count will not be present in the response of
     * any of these endpoints: [BatchChangeInventory]($e/Inventory/BatchChangeInventory),
     * [BatchRetrieveInventoryChanges]($e/Inventory/BatchRetrieveInventoryChanges),
     * [BatchRetrieveInventoryCounts]($e/Inventory/BatchRetrieveInventoryCounts), and
     * [RetrieveInventoryChanges]($e/Inventory/RetrieveInventoryChanges).
     *
     * @maps is_estimated
     */
    public function setIsEstimated(?bool $isEstimated): void
    {
        $this->isEstimated = $isEstimated;
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
        if (!empty($this->catalogObjectId)) {
            $json['catalog_object_id']   = $this->catalogObjectId['value'];
        }
        if (!empty($this->catalogObjectType)) {
            $json['catalog_object_type'] = $this->catalogObjectType['value'];
        }
        if (isset($this->state)) {
            $json['state']               = $this->state;
        }
        if (!empty($this->locationId)) {
            $json['location_id']         = $this->locationId['value'];
        }
        if (!empty($this->quantity)) {
            $json['quantity']            = $this->quantity['value'];
        }
        if (isset($this->calculatedAt)) {
            $json['calculated_at']       = $this->calculatedAt;
        }
        if (isset($this->isEstimated)) {
            $json['is_estimated']        = $this->isEstimated;
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
