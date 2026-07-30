<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\CatalogItemVariation;
use Square\Models\CatalogStockConversion;
use Square\Models\Money;

/**
 * Builder for model CatalogItemVariation
 *
 * @see CatalogItemVariation
 */
class CatalogItemVariationBuilder
{
    /**
     * @var CatalogItemVariation
     */
    private $instance;

    private function __construct(CatalogItemVariation $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new catalog item variation Builder object.
     */
    public static function init(): self
    {
        return new self(new CatalogItemVariation());
    }

    /**
     * Sets item id field.
     */
    public function itemId(?string $value): self
    {
        $this->instance->setItemId($value);
        return $this;
    }

    /**
     * Unsets item id field.
     */
    public function unsetItemId(): self
    {
        $this->instance->unsetItemId();
        return $this;
    }

    /**
     * Sets name field.
     */
    public function name(?string $value): self
    {
        $this->instance->setName($value);
        return $this;
    }

    /**
     * Unsets name field.
     */
    public function unsetName(): self
    {
        $this->instance->unsetName();
        return $this;
    }

    /**
     * Sets sku field.
     */
    public function sku(?string $value): self
    {
        $this->instance->setSku($value);
        return $this;
    }

    /**
     * Unsets sku field.
     */
    public function unsetSku(): self
    {
        $this->instance->unsetSku();
        return $this;
    }

    /**
     * Sets upc field.
     */
    public function upc(?string $value): self
    {
        $this->instance->setUpc($value);
        return $this;
    }

    /**
     * Unsets upc field.
     */
    public function unsetUpc(): self
    {
        $this->instance->unsetUpc();
        return $this;
    }

    /**
     * Sets ordinal field.
     */
    public function ordinal(?int $value): self
    {
        $this->instance->setOrdinal($value);
        return $this;
    }

    /**
     * Sets pricing type field.
     */
    public function pricingType(?string $value): self
    {
        $this->instance->setPricingType($value);
        return $this;
    }

    /**
     * Sets price money field.
     */
    public function priceMoney(?Money $value): self
    {
        $this->instance->setPriceMoney($value);
        return $this;
    }

    /**
     * Sets location overrides field.
     */
    public function locationOverrides(?array $value): self
    {
        $this->instance->setLocationOverrides($value);
        return $this;
    }

    /**
     * Unsets location overrides field.
     */
    public function unsetLocationOverrides(): self
    {
        $this->instance->unsetLocationOverrides();
        return $this;
    }

    /**
     * Sets track inventory field.
     */
    public function trackInventory(?bool $value): self
    {
        $this->instance->setTrackInventory($value);
        return $this;
    }

    /**
     * Unsets track inventory field.
     */
    public function unsetTrackInventory(): self
    {
        $this->instance->unsetTrackInventory();
        return $this;
    }

    /**
     * Sets inventory alert type field.
     */
    public function inventoryAlertType(?string $value): self
    {
        $this->instance->setInventoryAlertType($value);
        return $this;
    }

    /**
     * Sets inventory alert threshold field.
     */
    public function inventoryAlertThreshold(?int $value): self
    {
        $this->instance->setInventoryAlertThreshold($value);
        return $this;
    }

    /**
     * Unsets inventory alert threshold field.
     */
    public function unsetInventoryAlertThreshold(): self
    {
        $this->instance->unsetInventoryAlertThreshold();
        return $this;
    }

    /**
     * Sets user data field.
     */
    public function userData(?string $value): self
    {
        $this->instance->setUserData($value);
        return $this;
    }

    /**
     * Unsets user data field.
     */
    public function unsetUserData(): self
    {
        $this->instance->unsetUserData();
        return $this;
    }

    /**
     * Sets service duration field.
     */
    public function serviceDuration(?int $value): self
    {
        $this->instance->setServiceDuration($value);
        return $this;
    }

    /**
     * Unsets service duration field.
     */
    public function unsetServiceDuration(): self
    {
        $this->instance->unsetServiceDuration();
        return $this;
    }

    /**
     * Sets available for booking field.
     */
    public function availableForBooking(?bool $value): self
    {
        $this->instance->setAvailableForBooking($value);
        return $this;
    }

    /**
     * Unsets available for booking field.
     */
    public function unsetAvailableForBooking(): self
    {
        $this->instance->unsetAvailableForBooking();
        return $this;
    }

    /**
     * Sets item option values field.
     */
    public function itemOptionValues(?array $value): self
    {
        $this->instance->setItemOptionValues($value);
        return $this;
    }

    /**
     * Unsets item option values field.
     */
    public function unsetItemOptionValues(): self
    {
        $this->instance->unsetItemOptionValues();
        return $this;
    }

    /**
     * Sets measurement unit id field.
     */
    public function measurementUnitId(?string $value): self
    {
        $this->instance->setMeasurementUnitId($value);
        return $this;
    }

    /**
     * Unsets measurement unit id field.
     */
    public function unsetMeasurementUnitId(): self
    {
        $this->instance->unsetMeasurementUnitId();
        return $this;
    }

    /**
     * Sets sellable field.
     */
    public function sellable(?bool $value): self
    {
        $this->instance->setSellable($value);
        return $this;
    }

    /**
     * Unsets sellable field.
     */
    public function unsetSellable(): self
    {
        $this->instance->unsetSellable();
        return $this;
    }

    /**
     * Sets stockable field.
     */
    public function stockable(?bool $value): self
    {
        $this->instance->setStockable($value);
        return $this;
    }

    /**
     * Unsets stockable field.
     */
    public function unsetStockable(): self
    {
        $this->instance->unsetStockable();
        return $this;
    }

    /**
     * Sets image ids field.
     */
    public function imageIds(?array $value): self
    {
        $this->instance->setImageIds($value);
        return $this;
    }

    /**
     * Unsets image ids field.
     */
    public function unsetImageIds(): self
    {
        $this->instance->unsetImageIds();
        return $this;
    }

    /**
     * Sets team member ids field.
     */
    public function teamMemberIds(?array $value): self
    {
        $this->instance->setTeamMemberIds($value);
        return $this;
    }

    /**
     * Unsets team member ids field.
     */
    public function unsetTeamMemberIds(): self
    {
        $this->instance->unsetTeamMemberIds();
        return $this;
    }

    /**
     * Sets stockable conversion field.
     */
    public function stockableConversion(?CatalogStockConversion $value): self
    {
        $this->instance->setStockableConversion($value);
        return $this;
    }

    /**
     * Sets item variation vendor info ids field.
     */
    public function itemVariationVendorInfoIds(?array $value): self
    {
        $this->instance->setItemVariationVendorInfoIds($value);
        return $this;
    }

    /**
     * Unsets item variation vendor info ids field.
     */
    public function unsetItemVariationVendorInfoIds(): self
    {
        $this->instance->unsetItemVariationVendorInfoIds();
        return $this;
    }

    /**
     * Initializes a new catalog item variation object.
     */
    public function build(): CatalogItemVariation
    {
        return CoreHelper::clone($this->instance);
    }
}
