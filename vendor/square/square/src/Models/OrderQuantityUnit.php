<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Contains the measurement unit for a quantity and a precision that
 * specifies the number of digits after the decimal point for decimal quantities.
 */
class OrderQuantityUnit implements \JsonSerializable
{
    /**
     * @var MeasurementUnit|null
     */
    private $measurementUnit;

    /**
     * @var array
     */
    private $precision = [];

    /**
     * @var array
     */
    private $catalogObjectId = [];

    /**
     * @var array
     */
    private $catalogVersion = [];

    /**
     * Returns Measurement Unit.
     * Represents a unit of measurement to use with a quantity, such as ounces
     * or inches. Exactly one of the following fields are required: `custom_unit`,
     * `area_unit`, `length_unit`, `volume_unit`, and `weight_unit`.
     */
    public function getMeasurementUnit(): ?MeasurementUnit
    {
        return $this->measurementUnit;
    }

    /**
     * Sets Measurement Unit.
     * Represents a unit of measurement to use with a quantity, such as ounces
     * or inches. Exactly one of the following fields are required: `custom_unit`,
     * `area_unit`, `length_unit`, `volume_unit`, and `weight_unit`.
     *
     * @maps measurement_unit
     */
    public function setMeasurementUnit(?MeasurementUnit $measurementUnit): void
    {
        $this->measurementUnit = $measurementUnit;
    }

    /**
     * Returns Precision.
     * For non-integer quantities, represents the number of digits after the decimal point that are
     * recorded for this quantity.
     *
     * For example, a precision of 1 allows quantities such as `"1.0"` and `"1.1"`, but not `"1.01"`.
     *
     * Min: 0. Max: 5.
     */
    public function getPrecision(): ?int
    {
        if (count($this->precision) == 0) {
            return null;
        }
        return $this->precision['value'];
    }

    /**
     * Sets Precision.
     * For non-integer quantities, represents the number of digits after the decimal point that are
     * recorded for this quantity.
     *
     * For example, a precision of 1 allows quantities such as `"1.0"` and `"1.1"`, but not `"1.01"`.
     *
     * Min: 0. Max: 5.
     *
     * @maps precision
     */
    public function setPrecision(?int $precision): void
    {
        $this->precision['value'] = $precision;
    }

    /**
     * Unsets Precision.
     * For non-integer quantities, represents the number of digits after the decimal point that are
     * recorded for this quantity.
     *
     * For example, a precision of 1 allows quantities such as `"1.0"` and `"1.1"`, but not `"1.01"`.
     *
     * Min: 0. Max: 5.
     */
    public function unsetPrecision(): void
    {
        $this->precision = [];
    }

    /**
     * Returns Catalog Object Id.
     * The catalog object ID referencing the
     * [CatalogMeasurementUnit](entity:CatalogMeasurementUnit).
     *
     * This field is set when this is a catalog-backed measurement unit.
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
     * The catalog object ID referencing the
     * [CatalogMeasurementUnit](entity:CatalogMeasurementUnit).
     *
     * This field is set when this is a catalog-backed measurement unit.
     *
     * @maps catalog_object_id
     */
    public function setCatalogObjectId(?string $catalogObjectId): void
    {
        $this->catalogObjectId['value'] = $catalogObjectId;
    }

    /**
     * Unsets Catalog Object Id.
     * The catalog object ID referencing the
     * [CatalogMeasurementUnit](entity:CatalogMeasurementUnit).
     *
     * This field is set when this is a catalog-backed measurement unit.
     */
    public function unsetCatalogObjectId(): void
    {
        $this->catalogObjectId = [];
    }

    /**
     * Returns Catalog Version.
     * The version of the catalog object that this measurement unit references.
     *
     * This field is set when this is a catalog-backed measurement unit.
     */
    public function getCatalogVersion(): ?int
    {
        if (count($this->catalogVersion) == 0) {
            return null;
        }
        return $this->catalogVersion['value'];
    }

    /**
     * Sets Catalog Version.
     * The version of the catalog object that this measurement unit references.
     *
     * This field is set when this is a catalog-backed measurement unit.
     *
     * @maps catalog_version
     */
    public function setCatalogVersion(?int $catalogVersion): void
    {
        $this->catalogVersion['value'] = $catalogVersion;
    }

    /**
     * Unsets Catalog Version.
     * The version of the catalog object that this measurement unit references.
     *
     * This field is set when this is a catalog-backed measurement unit.
     */
    public function unsetCatalogVersion(): void
    {
        $this->catalogVersion = [];
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
        if (isset($this->measurementUnit)) {
            $json['measurement_unit']  = $this->measurementUnit;
        }
        if (!empty($this->precision)) {
            $json['precision']         = $this->precision['value'];
        }
        if (!empty($this->catalogObjectId)) {
            $json['catalog_object_id'] = $this->catalogObjectId['value'];
        }
        if (!empty($this->catalogVersion)) {
            $json['catalog_version']   = $this->catalogVersion['value'];
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
