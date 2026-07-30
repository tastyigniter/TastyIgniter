<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Represents a single physical count, inventory, adjustment, or transfer
 * that is part of the history of inventory changes for a particular
 * [CatalogObject]($m/CatalogObject) instance.
 */
class InventoryChange implements \JsonSerializable
{
    /**
     * @var string|null
     */
    private $type;

    /**
     * @var InventoryPhysicalCount|null
     */
    private $physicalCount;

    /**
     * @var InventoryAdjustment|null
     */
    private $adjustment;

    /**
     * @var InventoryTransfer|null
     */
    private $transfer;

    /**
     * @var CatalogMeasurementUnit|null
     */
    private $measurementUnit;

    /**
     * @var string|null
     */
    private $measurementUnitId;

    /**
     * Returns Type.
     * Indicates how the inventory change was applied to a tracked product quantity.
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * Sets Type.
     * Indicates how the inventory change was applied to a tracked product quantity.
     *
     * @maps type
     */
    public function setType(?string $type): void
    {
        $this->type = $type;
    }

    /**
     * Returns Physical Count.
     * Represents the quantity of an item variation that is physically present
     * at a specific location, verified by a seller or a seller's employee. For example,
     * a physical count might come from an employee counting the item variations on
     * hand or from syncing with an external system.
     */
    public function getPhysicalCount(): ?InventoryPhysicalCount
    {
        return $this->physicalCount;
    }

    /**
     * Sets Physical Count.
     * Represents the quantity of an item variation that is physically present
     * at a specific location, verified by a seller or a seller's employee. For example,
     * a physical count might come from an employee counting the item variations on
     * hand or from syncing with an external system.
     *
     * @maps physical_count
     */
    public function setPhysicalCount(?InventoryPhysicalCount $physicalCount): void
    {
        $this->physicalCount = $physicalCount;
    }

    /**
     * Returns Adjustment.
     * Represents a change in state or quantity of product inventory at a
     * particular time and location.
     */
    public function getAdjustment(): ?InventoryAdjustment
    {
        return $this->adjustment;
    }

    /**
     * Sets Adjustment.
     * Represents a change in state or quantity of product inventory at a
     * particular time and location.
     *
     * @maps adjustment
     */
    public function setAdjustment(?InventoryAdjustment $adjustment): void
    {
        $this->adjustment = $adjustment;
    }

    /**
     * Returns Transfer.
     * Represents the transfer of a quantity of product inventory at a
     * particular time from one location to another.
     */
    public function getTransfer(): ?InventoryTransfer
    {
        return $this->transfer;
    }

    /**
     * Sets Transfer.
     * Represents the transfer of a quantity of product inventory at a
     * particular time from one location to another.
     *
     * @maps transfer
     */
    public function setTransfer(?InventoryTransfer $transfer): void
    {
        $this->transfer = $transfer;
    }

    /**
     * Returns Measurement Unit.
     * Represents the unit used to measure a `CatalogItemVariation` and
     * specifies the precision for decimal quantities.
     */
    public function getMeasurementUnit(): ?CatalogMeasurementUnit
    {
        return $this->measurementUnit;
    }

    /**
     * Sets Measurement Unit.
     * Represents the unit used to measure a `CatalogItemVariation` and
     * specifies the precision for decimal quantities.
     *
     * @maps measurement_unit
     */
    public function setMeasurementUnit(?CatalogMeasurementUnit $measurementUnit): void
    {
        $this->measurementUnit = $measurementUnit;
    }

    /**
     * Returns Measurement Unit Id.
     * The ID of the [CatalogMeasurementUnit](entity:CatalogMeasurementUnit) object representing the
     * catalog measurement unit associated with the inventory change.
     */
    public function getMeasurementUnitId(): ?string
    {
        return $this->measurementUnitId;
    }

    /**
     * Sets Measurement Unit Id.
     * The ID of the [CatalogMeasurementUnit](entity:CatalogMeasurementUnit) object representing the
     * catalog measurement unit associated with the inventory change.
     *
     * @maps measurement_unit_id
     */
    public function setMeasurementUnitId(?string $measurementUnitId): void
    {
        $this->measurementUnitId = $measurementUnitId;
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
        if (isset($this->type)) {
            $json['type']                = $this->type;
        }
        if (isset($this->physicalCount)) {
            $json['physical_count']      = $this->physicalCount;
        }
        if (isset($this->adjustment)) {
            $json['adjustment']          = $this->adjustment;
        }
        if (isset($this->transfer)) {
            $json['transfer']            = $this->transfer;
        }
        if (isset($this->measurementUnit)) {
            $json['measurement_unit']    = $this->measurementUnit;
        }
        if (isset($this->measurementUnitId)) {
            $json['measurement_unit_id'] = $this->measurementUnitId;
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
