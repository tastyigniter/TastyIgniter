<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\CatalogMeasurementUnit;
use Square\Models\InventoryAdjustment;
use Square\Models\InventoryChange;
use Square\Models\InventoryPhysicalCount;
use Square\Models\InventoryTransfer;

/**
 * Builder for model InventoryChange
 *
 * @see InventoryChange
 */
class InventoryChangeBuilder
{
    /**
     * @var InventoryChange
     */
    private $instance;

    private function __construct(InventoryChange $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new inventory change Builder object.
     */
    public static function init(): self
    {
        return new self(new InventoryChange());
    }

    /**
     * Sets type field.
     */
    public function type(?string $value): self
    {
        $this->instance->setType($value);
        return $this;
    }

    /**
     * Sets physical count field.
     */
    public function physicalCount(?InventoryPhysicalCount $value): self
    {
        $this->instance->setPhysicalCount($value);
        return $this;
    }

    /**
     * Sets adjustment field.
     */
    public function adjustment(?InventoryAdjustment $value): self
    {
        $this->instance->setAdjustment($value);
        return $this;
    }

    /**
     * Sets transfer field.
     */
    public function transfer(?InventoryTransfer $value): self
    {
        $this->instance->setTransfer($value);
        return $this;
    }

    /**
     * Sets measurement unit field.
     */
    public function measurementUnit(?CatalogMeasurementUnit $value): self
    {
        $this->instance->setMeasurementUnit($value);
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
     * Initializes a new inventory change object.
     */
    public function build(): InventoryChange
    {
        return CoreHelper::clone($this->instance);
    }
}
