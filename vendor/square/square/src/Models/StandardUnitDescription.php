<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Contains the name and abbreviation for standard measurement unit.
 */
class StandardUnitDescription implements \JsonSerializable
{
    /**
     * @var MeasurementUnit|null
     */
    private $unit;

    /**
     * @var array
     */
    private $name = [];

    /**
     * @var array
     */
    private $abbreviation = [];

    /**
     * Returns Unit.
     * Represents a unit of measurement to use with a quantity, such as ounces
     * or inches. Exactly one of the following fields are required: `custom_unit`,
     * `area_unit`, `length_unit`, `volume_unit`, and `weight_unit`.
     */
    public function getUnit(): ?MeasurementUnit
    {
        return $this->unit;
    }

    /**
     * Sets Unit.
     * Represents a unit of measurement to use with a quantity, such as ounces
     * or inches. Exactly one of the following fields are required: `custom_unit`,
     * `area_unit`, `length_unit`, `volume_unit`, and `weight_unit`.
     *
     * @maps unit
     */
    public function setUnit(?MeasurementUnit $unit): void
    {
        $this->unit = $unit;
    }

    /**
     * Returns Name.
     * UI display name of the measurement unit. For example, 'Pound'.
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
     * UI display name of the measurement unit. For example, 'Pound'.
     *
     * @maps name
     */
    public function setName(?string $name): void
    {
        $this->name['value'] = $name;
    }

    /**
     * Unsets Name.
     * UI display name of the measurement unit. For example, 'Pound'.
     */
    public function unsetName(): void
    {
        $this->name = [];
    }

    /**
     * Returns Abbreviation.
     * UI display abbreviation for the measurement unit. For example, 'lb'.
     */
    public function getAbbreviation(): ?string
    {
        if (count($this->abbreviation) == 0) {
            return null;
        }
        return $this->abbreviation['value'];
    }

    /**
     * Sets Abbreviation.
     * UI display abbreviation for the measurement unit. For example, 'lb'.
     *
     * @maps abbreviation
     */
    public function setAbbreviation(?string $abbreviation): void
    {
        $this->abbreviation['value'] = $abbreviation;
    }

    /**
     * Unsets Abbreviation.
     * UI display abbreviation for the measurement unit. For example, 'lb'.
     */
    public function unsetAbbreviation(): void
    {
        $this->abbreviation = [];
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
        if (isset($this->unit)) {
            $json['unit']         = $this->unit;
        }
        if (!empty($this->name)) {
            $json['name']         = $this->name['value'];
        }
        if (!empty($this->abbreviation)) {
            $json['abbreviation'] = $this->abbreviation['value'];
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
