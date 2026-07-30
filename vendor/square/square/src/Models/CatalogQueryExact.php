<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * The query filter to return the search result by exact match of the specified attribute name and
 * value.
 */
class CatalogQueryExact implements \JsonSerializable
{
    /**
     * @var string
     */
    private $attributeName;

    /**
     * @var string
     */
    private $attributeValue;

    /**
     * @param string $attributeName
     * @param string $attributeValue
     */
    public function __construct(string $attributeName, string $attributeValue)
    {
        $this->attributeName = $attributeName;
        $this->attributeValue = $attributeValue;
    }

    /**
     * Returns Attribute Name.
     * The name of the attribute to be searched. Matching of the attribute name is exact.
     */
    public function getAttributeName(): string
    {
        return $this->attributeName;
    }

    /**
     * Sets Attribute Name.
     * The name of the attribute to be searched. Matching of the attribute name is exact.
     *
     * @required
     * @maps attribute_name
     */
    public function setAttributeName(string $attributeName): void
    {
        $this->attributeName = $attributeName;
    }

    /**
     * Returns Attribute Value.
     * The desired value of the search attribute. Matching of the attribute value is case insensitive and
     * can be partial.
     * For example, if a specified value of "sma", objects with the named attribute value of "Small",
     * "small" are both matched.
     */
    public function getAttributeValue(): string
    {
        return $this->attributeValue;
    }

    /**
     * Sets Attribute Value.
     * The desired value of the search attribute. Matching of the attribute value is case insensitive and
     * can be partial.
     * For example, if a specified value of "sma", objects with the named attribute value of "Small",
     * "small" are both matched.
     *
     * @required
     * @maps attribute_value
     */
    public function setAttributeValue(string $attributeValue): void
    {
        $this->attributeValue = $attributeValue;
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
        $json['attribute_name']  = $this->attributeName;
        $json['attribute_value'] = $this->attributeValue;
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
