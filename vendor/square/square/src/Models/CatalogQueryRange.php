<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * The query filter to return the search result whose named attribute values fall between the specified
 * range.
 */
class CatalogQueryRange implements \JsonSerializable
{
    /**
     * @var string
     */
    private $attributeName;

    /**
     * @var array
     */
    private $attributeMinValue = [];

    /**
     * @var array
     */
    private $attributeMaxValue = [];

    /**
     * @param string $attributeName
     */
    public function __construct(string $attributeName)
    {
        $this->attributeName = $attributeName;
    }

    /**
     * Returns Attribute Name.
     * The name of the attribute to be searched.
     */
    public function getAttributeName(): string
    {
        return $this->attributeName;
    }

    /**
     * Sets Attribute Name.
     * The name of the attribute to be searched.
     *
     * @required
     * @maps attribute_name
     */
    public function setAttributeName(string $attributeName): void
    {
        $this->attributeName = $attributeName;
    }

    /**
     * Returns Attribute Min Value.
     * The desired minimum value for the search attribute (inclusive).
     */
    public function getAttributeMinValue(): ?int
    {
        if (count($this->attributeMinValue) == 0) {
            return null;
        }
        return $this->attributeMinValue['value'];
    }

    /**
     * Sets Attribute Min Value.
     * The desired minimum value for the search attribute (inclusive).
     *
     * @maps attribute_min_value
     */
    public function setAttributeMinValue(?int $attributeMinValue): void
    {
        $this->attributeMinValue['value'] = $attributeMinValue;
    }

    /**
     * Unsets Attribute Min Value.
     * The desired minimum value for the search attribute (inclusive).
     */
    public function unsetAttributeMinValue(): void
    {
        $this->attributeMinValue = [];
    }

    /**
     * Returns Attribute Max Value.
     * The desired maximum value for the search attribute (inclusive).
     */
    public function getAttributeMaxValue(): ?int
    {
        if (count($this->attributeMaxValue) == 0) {
            return null;
        }
        return $this->attributeMaxValue['value'];
    }

    /**
     * Sets Attribute Max Value.
     * The desired maximum value for the search attribute (inclusive).
     *
     * @maps attribute_max_value
     */
    public function setAttributeMaxValue(?int $attributeMaxValue): void
    {
        $this->attributeMaxValue['value'] = $attributeMaxValue;
    }

    /**
     * Unsets Attribute Max Value.
     * The desired maximum value for the search attribute (inclusive).
     */
    public function unsetAttributeMaxValue(): void
    {
        $this->attributeMaxValue = [];
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
        $json['attribute_name']          = $this->attributeName;
        if (!empty($this->attributeMinValue)) {
            $json['attribute_min_value'] = $this->attributeMinValue['value'];
        }
        if (!empty($this->attributeMaxValue)) {
            $json['attribute_max_value'] = $this->attributeMaxValue['value'];
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
