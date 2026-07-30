<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\CatalogMeasurementUnit;
use Square\Models\MeasurementUnit;

/**
 * Builder for model CatalogMeasurementUnit
 *
 * @see CatalogMeasurementUnit
 */
class CatalogMeasurementUnitBuilder
{
    /**
     * @var CatalogMeasurementUnit
     */
    private $instance;

    private function __construct(CatalogMeasurementUnit $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new catalog measurement unit Builder object.
     */
    public static function init(): self
    {
        return new self(new CatalogMeasurementUnit());
    }

    /**
     * Sets measurement unit field.
     */
    public function measurementUnit(?MeasurementUnit $value): self
    {
        $this->instance->setMeasurementUnit($value);
        return $this;
    }

    /**
     * Sets precision field.
     */
    public function precision(?int $value): self
    {
        $this->instance->setPrecision($value);
        return $this;
    }

    /**
     * Unsets precision field.
     */
    public function unsetPrecision(): self
    {
        $this->instance->unsetPrecision();
        return $this;
    }

    /**
     * Initializes a new catalog measurement unit object.
     */
    public function build(): CatalogMeasurementUnit
    {
        return CoreHelper::clone($this->instance);
    }
}
