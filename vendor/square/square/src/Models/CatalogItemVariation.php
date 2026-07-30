<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * An item variation, representing a product for sale, in the Catalog object model. Each
 * [item]($m/CatalogItem) must have at least one
 * item variation and can have at most 250 item variations.
 *
 * An item variation can be sellable, stockable, or both if it has a unit of measure for its count for
 * the sold number of the variation, the stocked
 * number of the variation, or both. For example, when a variation representing wine is stocked and
 * sold by the bottle, the variation is both
 * stockable and sellable. But when a variation of the wine is sold by the glass, the sold units cannot
 * be used as a measure of the stocked units. This by-the-glass
 * variation is sellable, but not stockable. To accurately keep track of the wine's inventory count at
 * any time, the sellable count must be
 * converted to stockable count. Typically, the seller defines this unit conversion. For example, 1
 * bottle equals 5 glasses. The Square API exposes
 * the `stockable_conversion` property on the variation to specify the conversion. Thus, when two
 * glasses of the wine are sold, the sellable count
 * decreases by 2, and the stockable count automatically decreases by 0.4 bottle according to the
 * conversion.
 */
class CatalogItemVariation implements \JsonSerializable
{
    /**
     * @var array
     */
    private $itemId = [];

    /**
     * @var array
     */
    private $name = [];

    /**
     * @var array
     */
    private $sku = [];

    /**
     * @var array
     */
    private $upc = [];

    /**
     * @var int|null
     */
    private $ordinal;

    /**
     * @var string|null
     */
    private $pricingType;

    /**
     * @var Money|null
     */
    private $priceMoney;

    /**
     * @var array
     */
    private $locationOverrides = [];

    /**
     * @var array
     */
    private $trackInventory = [];

    /**
     * @var string|null
     */
    private $inventoryAlertType;

    /**
     * @var array
     */
    private $inventoryAlertThreshold = [];

    /**
     * @var array
     */
    private $userData = [];

    /**
     * @var array
     */
    private $serviceDuration = [];

    /**
     * @var array
     */
    private $availableForBooking = [];

    /**
     * @var array
     */
    private $itemOptionValues = [];

    /**
     * @var array
     */
    private $measurementUnitId = [];

    /**
     * @var array
     */
    private $sellable = [];

    /**
     * @var array
     */
    private $stockable = [];

    /**
     * @var array
     */
    private $imageIds = [];

    /**
     * @var array
     */
    private $teamMemberIds = [];

    /**
     * @var CatalogStockConversion|null
     */
    private $stockableConversion;

    /**
     * @var array
     */
    private $itemVariationVendorInfoIds = [];

    /**
     * Returns Item Id.
     * The ID of the `CatalogItem` associated with this item variation.
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
     * The ID of the `CatalogItem` associated with this item variation.
     *
     * @maps item_id
     */
    public function setItemId(?string $itemId): void
    {
        $this->itemId['value'] = $itemId;
    }

    /**
     * Unsets Item Id.
     * The ID of the `CatalogItem` associated with this item variation.
     */
    public function unsetItemId(): void
    {
        $this->itemId = [];
    }

    /**
     * Returns Name.
     * The item variation's name. This is a searchable attribute for use in applicable query filters, and
     * its value length is of Unicode code points.
     */
    public function getName(): ?string
    {
        if (count($this->name) == 0) {
            return null;
        }
        return $this->name['value'];
    }

    /**
     * Sets Name.
     * The item variation's name. This is a searchable attribute for use in applicable query filters, and
     * its value length is of Unicode code points.
     *
     * @maps name
     */
    public function setName(?string $name): void
    {
        $this->name['value'] = $name;
    }

    /**
     * Unsets Name.
     * The item variation's name. This is a searchable attribute for use in applicable query filters, and
     * its value length is of Unicode code points.
     */
    public function unsetName(): void
    {
        $this->name = [];
    }

    /**
     * Returns Sku.
     * The item variation's SKU, if any. This is a searchable attribute for use in applicable query filters.
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
     * The item variation's SKU, if any. This is a searchable attribute for use in applicable query filters.
     *
     * @maps sku
     */
    public function setSku(?string $sku): void
    {
        $this->sku['value'] = $sku;
    }

    /**
     * Unsets Sku.
     * The item variation's SKU, if any. This is a searchable attribute for use in applicable query filters.
     */
    public function unsetSku(): void
    {
        $this->sku = [];
    }

    /**
     * Returns Upc.
     * The universal product code (UPC) of the item variation, if any. This is a searchable attribute for
     * use in applicable query filters.
     *
     * The value of this attribute should be a number of 12-14 digits long.  This restriction is enforced
     * on the Square Seller Dashboard,
     * Square Point of Sale or Retail Point of Sale apps, where this attribute shows in the GTIN field. If
     * a non-compliant UPC value is assigned
     * to this attribute using the API, the value is not editable on the Seller Dashboard, Square Point of
     * Sale or Retail Point of Sale apps
     * unless it is updated to fit the expected format.
     */
    public function getUpc(): ?string
    {
        if (count($this->upc) == 0) {
            return null;
        }
        return $this->upc['value'];
    }

    /**
     * Sets Upc.
     * The universal product code (UPC) of the item variation, if any. This is a searchable attribute for
     * use in applicable query filters.
     *
     * The value of this attribute should be a number of 12-14 digits long.  This restriction is enforced
     * on the Square Seller Dashboard,
     * Square Point of Sale or Retail Point of Sale apps, where this attribute shows in the GTIN field. If
     * a non-compliant UPC value is assigned
     * to this attribute using the API, the value is not editable on the Seller Dashboard, Square Point of
     * Sale or Retail Point of Sale apps
     * unless it is updated to fit the expected format.
     *
     * @maps upc
     */
    public function setUpc(?string $upc): void
    {
        $this->upc['value'] = $upc;
    }

    /**
     * Unsets Upc.
     * The universal product code (UPC) of the item variation, if any. This is a searchable attribute for
     * use in applicable query filters.
     *
     * The value of this attribute should be a number of 12-14 digits long.  This restriction is enforced
     * on the Square Seller Dashboard,
     * Square Point of Sale or Retail Point of Sale apps, where this attribute shows in the GTIN field. If
     * a non-compliant UPC value is assigned
     * to this attribute using the API, the value is not editable on the Seller Dashboard, Square Point of
     * Sale or Retail Point of Sale apps
     * unless it is updated to fit the expected format.
     */
    public function unsetUpc(): void
    {
        $this->upc = [];
    }

    /**
     * Returns Ordinal.
     * The order in which this item variation should be displayed. This value is read-only. On writes, the
     * ordinal
     * for each item variation within a parent `CatalogItem` is set according to the item variations's
     * position. On reads, the value is not guaranteed to be sequential or unique.
     */
    public function getOrdinal(): ?int
    {
        return $this->ordinal;
    }

    /**
     * Sets Ordinal.
     * The order in which this item variation should be displayed. This value is read-only. On writes, the
     * ordinal
     * for each item variation within a parent `CatalogItem` is set according to the item variations's
     * position. On reads, the value is not guaranteed to be sequential or unique.
     *
     * @maps ordinal
     */
    public function setOrdinal(?int $ordinal): void
    {
        $this->ordinal = $ordinal;
    }

    /**
     * Returns Pricing Type.
     * Indicates whether the price of a CatalogItemVariation should be entered manually at the time of sale.
     */
    public function getPricingType(): ?string
    {
        return $this->pricingType;
    }

    /**
     * Sets Pricing Type.
     * Indicates whether the price of a CatalogItemVariation should be entered manually at the time of sale.
     *
     * @maps pricing_type
     */
    public function setPricingType(?string $pricingType): void
    {
        $this->pricingType = $pricingType;
    }

    /**
     * Returns Price Money.
     * Represents an amount of money. `Money` fields can be signed or unsigned.
     * Fields that do not explicitly define whether they are signed or unsigned are
     * considered unsigned and can only hold positive amounts. For signed fields, the
     * sign of the value indicates the purpose of the money transfer. See
     * [Working with Monetary Amounts](https://developer.squareup.com/docs/build-basics/working-with-
     * monetary-amounts)
     * for more information.
     */
    public function getPriceMoney(): ?Money
    {
        return $this->priceMoney;
    }

    /**
     * Sets Price Money.
     * Represents an amount of money. `Money` fields can be signed or unsigned.
     * Fields that do not explicitly define whether they are signed or unsigned are
     * considered unsigned and can only hold positive amounts. For signed fields, the
     * sign of the value indicates the purpose of the money transfer. See
     * [Working with Monetary Amounts](https://developer.squareup.com/docs/build-basics/working-with-
     * monetary-amounts)
     * for more information.
     *
     * @maps price_money
     */
    public function setPriceMoney(?Money $priceMoney): void
    {
        $this->priceMoney = $priceMoney;
    }

    /**
     * Returns Location Overrides.
     * Per-location price and inventory overrides.
     *
     * @return ItemVariationLocationOverrides[]|null
     */
    public function getLocationOverrides(): ?array
    {
        if (count($this->locationOverrides) == 0) {
            return null;
        }
        return $this->locationOverrides['value'];
    }

    /**
     * Sets Location Overrides.
     * Per-location price and inventory overrides.
     *
     * @maps location_overrides
     *
     * @param ItemVariationLocationOverrides[]|null $locationOverrides
     */
    public function setLocationOverrides(?array $locationOverrides): void
    {
        $this->locationOverrides['value'] = $locationOverrides;
    }

    /**
     * Unsets Location Overrides.
     * Per-location price and inventory overrides.
     */
    public function unsetLocationOverrides(): void
    {
        $this->locationOverrides = [];
    }

    /**
     * Returns Track Inventory.
     * If `true`, inventory tracking is active for the variation.
     */
    public function getTrackInventory(): ?bool
    {
        if (count($this->trackInventory) == 0) {
            return null;
        }
        return $this->trackInventory['value'];
    }

    /**
     * Sets Track Inventory.
     * If `true`, inventory tracking is active for the variation.
     *
     * @maps track_inventory
     */
    public function setTrackInventory(?bool $trackInventory): void
    {
        $this->trackInventory['value'] = $trackInventory;
    }

    /**
     * Unsets Track Inventory.
     * If `true`, inventory tracking is active for the variation.
     */
    public function unsetTrackInventory(): void
    {
        $this->trackInventory = [];
    }

    /**
     * Returns Inventory Alert Type.
     * Indicates whether Square should alert the merchant when the inventory quantity of a
     * CatalogItemVariation is low.
     */
    public function getInventoryAlertType(): ?string
    {
        return $this->inventoryAlertType;
    }

    /**
     * Sets Inventory Alert Type.
     * Indicates whether Square should alert the merchant when the inventory quantity of a
     * CatalogItemVariation is low.
     *
     * @maps inventory_alert_type
     */
    public function setInventoryAlertType(?string $inventoryAlertType): void
    {
        $this->inventoryAlertType = $inventoryAlertType;
    }

    /**
     * Returns Inventory Alert Threshold.
     * If the inventory quantity for the variation is less than or equal to this value and
     * `inventory_alert_type`
     * is `LOW_QUANTITY`, the variation displays an alert in the merchant dashboard.
     *
     * This value is always an integer.
     */
    public function getInventoryAlertThreshold(): ?int
    {
        if (count($this->inventoryAlertThreshold) == 0) {
            return null;
        }
        return $this->inventoryAlertThreshold['value'];
    }

    /**
     * Sets Inventory Alert Threshold.
     * If the inventory quantity for the variation is less than or equal to this value and
     * `inventory_alert_type`
     * is `LOW_QUANTITY`, the variation displays an alert in the merchant dashboard.
     *
     * This value is always an integer.
     *
     * @maps inventory_alert_threshold
     */
    public function setInventoryAlertThreshold(?int $inventoryAlertThreshold): void
    {
        $this->inventoryAlertThreshold['value'] = $inventoryAlertThreshold;
    }

    /**
     * Unsets Inventory Alert Threshold.
     * If the inventory quantity for the variation is less than or equal to this value and
     * `inventory_alert_type`
     * is `LOW_QUANTITY`, the variation displays an alert in the merchant dashboard.
     *
     * This value is always an integer.
     */
    public function unsetInventoryAlertThreshold(): void
    {
        $this->inventoryAlertThreshold = [];
    }

    /**
     * Returns User Data.
     * Arbitrary user metadata to associate with the item variation. This attribute value length is of
     * Unicode code points.
     */
    public function getUserData(): ?string
    {
        if (count($this->userData) == 0) {
            return null;
        }
        return $this->userData['value'];
    }

    /**
     * Sets User Data.
     * Arbitrary user metadata to associate with the item variation. This attribute value length is of
     * Unicode code points.
     *
     * @maps user_data
     */
    public function setUserData(?string $userData): void
    {
        $this->userData['value'] = $userData;
    }

    /**
     * Unsets User Data.
     * Arbitrary user metadata to associate with the item variation. This attribute value length is of
     * Unicode code points.
     */
    public function unsetUserData(): void
    {
        $this->userData = [];
    }

    /**
     * Returns Service Duration.
     * If the `CatalogItem` that owns this item variation is of type
     * `APPOINTMENTS_SERVICE`, then this is the duration of the service in milliseconds. For
     * example, a 30 minute appointment would have the value `1800000`, which is equal to
     * 30 (minutes) * 60 (seconds per minute) * 1000 (milliseconds per second).
     */
    public function getServiceDuration(): ?int
    {
        if (count($this->serviceDuration) == 0) {
            return null;
        }
        return $this->serviceDuration['value'];
    }

    /**
     * Sets Service Duration.
     * If the `CatalogItem` that owns this item variation is of type
     * `APPOINTMENTS_SERVICE`, then this is the duration of the service in milliseconds. For
     * example, a 30 minute appointment would have the value `1800000`, which is equal to
     * 30 (minutes) * 60 (seconds per minute) * 1000 (milliseconds per second).
     *
     * @maps service_duration
     */
    public function setServiceDuration(?int $serviceDuration): void
    {
        $this->serviceDuration['value'] = $serviceDuration;
    }

    /**
     * Unsets Service Duration.
     * If the `CatalogItem` that owns this item variation is of type
     * `APPOINTMENTS_SERVICE`, then this is the duration of the service in milliseconds. For
     * example, a 30 minute appointment would have the value `1800000`, which is equal to
     * 30 (minutes) * 60 (seconds per minute) * 1000 (milliseconds per second).
     */
    public function unsetServiceDuration(): void
    {
        $this->serviceDuration = [];
    }

    /**
     * Returns Available for Booking.
     * If the `CatalogItem` that owns this item variation is of type
     * `APPOINTMENTS_SERVICE`, a bool representing whether this service is available for booking.
     */
    public function getAvailableForBooking(): ?bool
    {
        if (count($this->availableForBooking) == 0) {
            return null;
        }
        return $this->availableForBooking['value'];
    }

    /**
     * Sets Available for Booking.
     * If the `CatalogItem` that owns this item variation is of type
     * `APPOINTMENTS_SERVICE`, a bool representing whether this service is available for booking.
     *
     * @maps available_for_booking
     */
    public function setAvailableForBooking(?bool $availableForBooking): void
    {
        $this->availableForBooking['value'] = $availableForBooking;
    }

    /**
     * Unsets Available for Booking.
     * If the `CatalogItem` that owns this item variation is of type
     * `APPOINTMENTS_SERVICE`, a bool representing whether this service is available for booking.
     */
    public function unsetAvailableForBooking(): void
    {
        $this->availableForBooking = [];
    }

    /**
     * Returns Item Option Values.
     * List of item option values associated with this item variation. Listed
     * in the same order as the item options of the parent item.
     *
     * @return CatalogItemOptionValueForItemVariation[]|null
     */
    public function getItemOptionValues(): ?array
    {
        if (count($this->itemOptionValues) == 0) {
            return null;
        }
        return $this->itemOptionValues['value'];
    }

    /**
     * Sets Item Option Values.
     * List of item option values associated with this item variation. Listed
     * in the same order as the item options of the parent item.
     *
     * @maps item_option_values
     *
     * @param CatalogItemOptionValueForItemVariation[]|null $itemOptionValues
     */
    public function setItemOptionValues(?array $itemOptionValues): void
    {
        $this->itemOptionValues['value'] = $itemOptionValues;
    }

    /**
     * Unsets Item Option Values.
     * List of item option values associated with this item variation. Listed
     * in the same order as the item options of the parent item.
     */
    public function unsetItemOptionValues(): void
    {
        $this->itemOptionValues = [];
    }

    /**
     * Returns Measurement Unit Id.
     * ID of the ‘CatalogMeasurementUnit’ that is used to measure the quantity
     * sold of this item variation. If left unset, the item will be sold in
     * whole quantities.
     */
    public function getMeasurementUnitId(): ?string
    {
        if (count($this->measurementUnitId) == 0) {
            return null;
        }
        return $this->measurementUnitId['value'];
    }

    /**
     * Sets Measurement Unit Id.
     * ID of the ‘CatalogMeasurementUnit’ that is used to measure the quantity
     * sold of this item variation. If left unset, the item will be sold in
     * whole quantities.
     *
     * @maps measurement_unit_id
     */
    public function setMeasurementUnitId(?string $measurementUnitId): void
    {
        $this->measurementUnitId['value'] = $measurementUnitId;
    }

    /**
     * Unsets Measurement Unit Id.
     * ID of the ‘CatalogMeasurementUnit’ that is used to measure the quantity
     * sold of this item variation. If left unset, the item will be sold in
     * whole quantities.
     */
    public function unsetMeasurementUnitId(): void
    {
        $this->measurementUnitId = [];
    }

    /**
     * Returns Sellable.
     * Whether this variation can be sold. The inventory count of a sellable variation indicates
     * the number of units available for sale. When a variation is both stockable and sellable,
     * its sellable inventory count can be smaller than or equal to its stockable count.
     */
    public function getSellable(): ?bool
    {
        if (count($this->sellable) == 0) {
            return null;
        }
        return $this->sellable['value'];
    }

    /**
     * Sets Sellable.
     * Whether this variation can be sold. The inventory count of a sellable variation indicates
     * the number of units available for sale. When a variation is both stockable and sellable,
     * its sellable inventory count can be smaller than or equal to its stockable count.
     *
     * @maps sellable
     */
    public function setSellable(?bool $sellable): void
    {
        $this->sellable['value'] = $sellable;
    }

    /**
     * Unsets Sellable.
     * Whether this variation can be sold. The inventory count of a sellable variation indicates
     * the number of units available for sale. When a variation is both stockable and sellable,
     * its sellable inventory count can be smaller than or equal to its stockable count.
     */
    public function unsetSellable(): void
    {
        $this->sellable = [];
    }

    /**
     * Returns Stockable.
     * Whether stock is counted directly on this variation (TRUE) or only on its components (FALSE).
     * When a variation is both stockable and sellable, the inventory count of a stockable variation keeps
     * track of the number of units of this variation in stock
     * and is not an indicator of the number of units of the variation that can be sold.
     */
    public function getStockable(): ?bool
    {
        if (count($this->stockable) == 0) {
            return null;
        }
        return $this->stockable['value'];
    }

    /**
     * Sets Stockable.
     * Whether stock is counted directly on this variation (TRUE) or only on its components (FALSE).
     * When a variation is both stockable and sellable, the inventory count of a stockable variation keeps
     * track of the number of units of this variation in stock
     * and is not an indicator of the number of units of the variation that can be sold.
     *
     * @maps stockable
     */
    public function setStockable(?bool $stockable): void
    {
        $this->stockable['value'] = $stockable;
    }

    /**
     * Unsets Stockable.
     * Whether stock is counted directly on this variation (TRUE) or only on its components (FALSE).
     * When a variation is both stockable and sellable, the inventory count of a stockable variation keeps
     * track of the number of units of this variation in stock
     * and is not an indicator of the number of units of the variation that can be sold.
     */
    public function unsetStockable(): void
    {
        $this->stockable = [];
    }

    /**
     * Returns Image Ids.
     * The IDs of images associated with this `CatalogItemVariation` instance.
     * These images will be shown to customers in Square Online Store.
     *
     * @return string[]|null
     */
    public function getImageIds(): ?array
    {
        if (count($this->imageIds) == 0) {
            return null;
        }
        return $this->imageIds['value'];
    }

    /**
     * Sets Image Ids.
     * The IDs of images associated with this `CatalogItemVariation` instance.
     * These images will be shown to customers in Square Online Store.
     *
     * @maps image_ids
     *
     * @param string[]|null $imageIds
     */
    public function setImageIds(?array $imageIds): void
    {
        $this->imageIds['value'] = $imageIds;
    }

    /**
     * Unsets Image Ids.
     * The IDs of images associated with this `CatalogItemVariation` instance.
     * These images will be shown to customers in Square Online Store.
     */
    public function unsetImageIds(): void
    {
        $this->imageIds = [];
    }

    /**
     * Returns Team Member Ids.
     * Tokens of employees that can perform the service represented by this variation. Only valid for
     * variations of type `APPOINTMENTS_SERVICE`.
     *
     * @return string[]|null
     */
    public function getTeamMemberIds(): ?array
    {
        if (count($this->teamMemberIds) == 0) {
            return null;
        }
        return $this->teamMemberIds['value'];
    }

    /**
     * Sets Team Member Ids.
     * Tokens of employees that can perform the service represented by this variation. Only valid for
     * variations of type `APPOINTMENTS_SERVICE`.
     *
     * @maps team_member_ids
     *
     * @param string[]|null $teamMemberIds
     */
    public function setTeamMemberIds(?array $teamMemberIds): void
    {
        $this->teamMemberIds['value'] = $teamMemberIds;
    }

    /**
     * Unsets Team Member Ids.
     * Tokens of employees that can perform the service represented by this variation. Only valid for
     * variations of type `APPOINTMENTS_SERVICE`.
     */
    public function unsetTeamMemberIds(): void
    {
        $this->teamMemberIds = [];
    }

    /**
     * Returns Stockable Conversion.
     * Represents the rule of conversion between a stockable
     * [CatalogItemVariation]($m/CatalogItemVariation)
     * and a non-stockable sell-by or receive-by `CatalogItemVariation` that
     * share the same underlying stock.
     */
    public function getStockableConversion(): ?CatalogStockConversion
    {
        return $this->stockableConversion;
    }

    /**
     * Sets Stockable Conversion.
     * Represents the rule of conversion between a stockable
     * [CatalogItemVariation]($m/CatalogItemVariation)
     * and a non-stockable sell-by or receive-by `CatalogItemVariation` that
     * share the same underlying stock.
     *
     * @maps stockable_conversion
     */
    public function setStockableConversion(?CatalogStockConversion $stockableConversion): void
    {
        $this->stockableConversion = $stockableConversion;
    }

    /**
     * Returns Item Variation Vendor Info Ids.
     * A list of ids of [CatalogItemVariationVendorInfo](entity:CatalogItemVariationVendorInfo) objects
     * that
     * reference this ItemVariation. (Deprecated in favor of item_variation_vendor_infos)
     *
     * @return string[]|null
     */
    public function getItemVariationVendorInfoIds(): ?array
    {
        if (count($this->itemVariationVendorInfoIds) == 0) {
            return null;
        }
        return $this->itemVariationVendorInfoIds['value'];
    }

    /**
     * Sets Item Variation Vendor Info Ids.
     * A list of ids of [CatalogItemVariationVendorInfo](entity:CatalogItemVariationVendorInfo) objects
     * that
     * reference this ItemVariation. (Deprecated in favor of item_variation_vendor_infos)
     *
     * @maps item_variation_vendor_info_ids
     *
     * @param string[]|null $itemVariationVendorInfoIds
     */
    public function setItemVariationVendorInfoIds(?array $itemVariationVendorInfoIds): void
    {
        $this->itemVariationVendorInfoIds['value'] = $itemVariationVendorInfoIds;
    }

    /**
     * Unsets Item Variation Vendor Info Ids.
     * A list of ids of [CatalogItemVariationVendorInfo](entity:CatalogItemVariationVendorInfo) objects
     * that
     * reference this ItemVariation. (Deprecated in favor of item_variation_vendor_infos)
     */
    public function unsetItemVariationVendorInfoIds(): void
    {
        $this->itemVariationVendorInfoIds = [];
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
        if (!empty($this->itemId)) {
            $json['item_id']                        = $this->itemId['value'];
        }
        if (!empty($this->name)) {
            $json['name']                           = $this->name['value'];
        }
        if (!empty($this->sku)) {
            $json['sku']                            = $this->sku['value'];
        }
        if (!empty($this->upc)) {
            $json['upc']                            = $this->upc['value'];
        }
        if (isset($this->ordinal)) {
            $json['ordinal']                        = $this->ordinal;
        }
        if (isset($this->pricingType)) {
            $json['pricing_type']                   = $this->pricingType;
        }
        if (isset($this->priceMoney)) {
            $json['price_money']                    = $this->priceMoney;
        }
        if (!empty($this->locationOverrides)) {
            $json['location_overrides']             = $this->locationOverrides['value'];
        }
        if (!empty($this->trackInventory)) {
            $json['track_inventory']                = $this->trackInventory['value'];
        }
        if (isset($this->inventoryAlertType)) {
            $json['inventory_alert_type']           = $this->inventoryAlertType;
        }
        if (!empty($this->inventoryAlertThreshold)) {
            $json['inventory_alert_threshold']      = $this->inventoryAlertThreshold['value'];
        }
        if (!empty($this->userData)) {
            $json['user_data']                      = $this->userData['value'];
        }
        if (!empty($this->serviceDuration)) {
            $json['service_duration']               = $this->serviceDuration['value'];
        }
        if (!empty($this->availableForBooking)) {
            $json['available_for_booking']          = $this->availableForBooking['value'];
        }
        if (!empty($this->itemOptionValues)) {
            $json['item_option_values']             = $this->itemOptionValues['value'];
        }
        if (!empty($this->measurementUnitId)) {
            $json['measurement_unit_id']            = $this->measurementUnitId['value'];
        }
        if (!empty($this->sellable)) {
            $json['sellable']                       = $this->sellable['value'];
        }
        if (!empty($this->stockable)) {
            $json['stockable']                      = $this->stockable['value'];
        }
        if (!empty($this->imageIds)) {
            $json['image_ids']                      = $this->imageIds['value'];
        }
        if (!empty($this->teamMemberIds)) {
            $json['team_member_ids']                = $this->teamMemberIds['value'];
        }
        if (isset($this->stockableConversion)) {
            $json['stockable_conversion']           = $this->stockableConversion;
        }
        if (!empty($this->itemVariationVendorInfoIds)) {
            $json['item_variation_vendor_info_ids'] = $this->itemVariationVendorInfoIds['value'];
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
