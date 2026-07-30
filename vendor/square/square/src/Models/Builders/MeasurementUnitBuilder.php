<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\MeasurementUnit;
use Square\Models\MeasurementUnitCustom;

/**
 * Builder for model MeasurementUnit
 *
 * @see MeasurementUnit
 */
class MeasurementUnitBuilder
{
    /**
     * @var MeasurementUnit
     */
    private $instance;

    private function __construct(MeasurementUnit $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new measurement unit Builder object.
     */
    public static function init(): self
    {
        return new self(new MeasurementUnit());
    }

    /**
     * Sets custom unit field.
     */
    public function customUnit(?MeasurementUnitCustom $value): self
    {
        $this->instance->setCustomUnit($value);
        return $this;
    }

    /**
     * Sets area unit field.
     */
    public function areaUnit(?string $value): self
    {
        $this->instance->setAreaUnit($value);
        return $this;
    }

    /**
     * Sets length unit field.
     */
    public function lengthUnit(?string $value): self
    {
        $this->instance->setLengthUnit($value);
        return $this;
    }

    /**
     * Sets volume unit field.
     */
    public function volumeUnit(?string $value): self
    {
        $this->instance->setVolumeUnit($value);
        return $this;
    }

    /**
     * Sets weight unit field.
     */
    public function weightUnit(?string $value): self
    {
        $this->instance->setWeightUnit($value);
        return $this;
    }

    /**
     * Sets generic unit field.
     */
    public function genericUnit(?string $value): self
    {
        $this->instance->setGenericUnit($value);
        return $this;
    }

    /**
     * Sets time unit field.
     */
    public function timeUnit(?string $value): self
    {
        $this->instance->setTimeUnit($value);
        return $this;
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
     * Initializes a new measurement unit object.
     */
    public function build(): MeasurementUnit
    {
        return CoreHelper::clone($this->instance);
    }
}
