<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Price and inventory alerting overrides for a `CatalogItemVariation` at a specific `Location`.
 */
class ItemVariationLocationOverrides implements \JsonSerializable
{
    /**
     * @var array
     */
    private $locationId = [];

    /**
     * @var Money|null
     */
    private $priceMoney;

    /**
     * @var string|null
     */
    private $pricingType;

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
     * @var bool|null
     */
    private $soldOut;

    /**
     * @var string|null
     */
    private $soldOutValidUntil;

    /**
     * Returns Location Id.
     * The ID of the `Location`. This can include locations that are deactivated.
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
     * The ID of the `Location`. This can include locations that are deactivated.
     *
     * @maps location_id
     */
    public function setLocationId(?string $locationId): void
    {
        $this->locationId['value'] = $locationId;
    }

    /**
     * Unsets Location Id.
     * The ID of the `Location`. This can include locations that are deactivated.
     */
    public function unsetLocationId(): void
    {
        $this->locationId = [];
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
     * Returns Track Inventory.
     * If `true`, inventory tracking is active for the `CatalogItemVariation` at this `Location`.
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
     * If `true`, inventory tracking is active for the `CatalogItemVariation` at this `Location`.
     *
     * @maps track_inventory
     */
    public function setTrackInventory(?bool $trackInventory): void
    {
        $this->trackInventory['value'] = $trackInventory;
    }

    /**
     * Unsets Track Inventory.
     * If `true`, inventory tracking is active for the `CatalogItemVariation` at this `Location`.
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
     * Returns Sold Out.
     * Indicates whether the overridden item variation is sold out at the specified location.
     *
     * When inventory tracking is enabled on the item variation either globally or at the specified
     * location,
     * the item variation is automatically marked as sold out when its inventory count reaches zero. The
     * seller
     * can manually set the item variation as sold out even when the inventory count is greater than zero.
     * Attempts by an application to set this attribute are ignored. Regardless how the sold-out status is
     * set,
     * applications should treat its inventory count as zero when this attribute value is `true`.
     */
    public function getSoldOut(): ?bool
    {
        return $this->soldOut;
    }

    /**
     * Sets Sold Out.
     * Indicates whether the overridden item variation is sold out at the specified location.
     *
     * When inventory tracking is enabled on the item variation either globally or at the specified
     * location,
     * the item variation is automatically marked as sold out when its inventory count reaches zero. The
     * seller
     * can manually set the item variation as sold out even when the inventory count is greater than zero.
     * Attempts by an application to set this attribute are ignored. Regardless how the sold-out status is
     * set,
     * applications should treat its inventory count as zero when this attribute value is `true`.
     *
     * @maps sold_out
     */
    public function setSoldOut(?bool $soldOut): void
    {
        $this->soldOut = $soldOut;
    }

    /**
     * Returns Sold Out Valid Until.
     * The seller-assigned timestamp, of the RFC 3339 format, to indicate when this sold-out variation
     * becomes available again at the specified location. Attempts by an application to set this attribute
     * are ignored.
     * When the current time is later than this attribute value, the affected item variation is no longer
     * sold out.
     */
    public function getSoldOutValidUntil(): ?string
    {
        return $this->soldOutValidUntil;
    }

    /**
     * Sets Sold Out Valid Until.
     * The seller-assigned timestamp, of the RFC 3339 format, to indicate when this sold-out variation
     * becomes available again at the specified location. Attempts by an application to set this attribute
     * are ignored.
     * When the current time is later than this attribute value, the affected item variation is no longer
     * sold out.
     *
     * @maps sold_out_valid_until
     */
    public function setSoldOutValidUntil(?string $soldOutValidUntil): void
    {
        $this->soldOutValidUntil = $soldOutValidUntil;
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
        if (!empty($this->locationId)) {
            $json['location_id']               = $this->locationId['value'];
        }
        if (isset($this->priceMoney)) {
            $json['price_money']               = $this->priceMoney;
        }
        if (isset($this->pricingType)) {
            $json['pricing_type']              = $this->pricingType;
        }
        if (!empty($this->trackInventory)) {
            $json['track_inventory']           = $this->trackInventory['value'];
        }
        if (isset($this->inventoryAlertType)) {
            $json['inventory_alert_type']      = $this->inventoryAlertType;
        }
        if (!empty($this->inventoryAlertThreshold)) {
            $json['inventory_alert_threshold'] = $this->inventoryAlertThreshold['value'];
        }
        if (isset($this->soldOut)) {
            $json['sold_out']                  = $this->soldOut;
        }
        if (isset($this->soldOutValidUntil)) {
            $json['sold_out_valid_until']      = $this->soldOutValidUntil;
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
