<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * The query filter to return the search result(s) by exact match of the specified `attribute_name` and
 * any of
 * the `attribute_values`.
 */
class CatalogQuerySet implements \JsonSerializable
{
    /**
     * @var string
     */
    private $attributeName;

    /**
     * @var string[]
     */
    private $attributeValues;

    /**
     * @param string $attributeName
     * @param string[] $attributeValues
     */
    public function __construct(string $attributeName, array $attributeValues)
    {
        $this->attributeName = $attributeName;
        $this->attributeValues = $attributeValues;
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
     * Returns Attribute Values.
     * The desired values of the search attribute. Matching of the attribute values is exact and case
     * insensitive.
     * A maximum of 250 values may be searched in a request.
     *
     * @return string[]
     */
    public function getAttributeValues(): array
    {
        return $this->attributeValues;
    }

    /**
     * Sets Attribute Values.
     * The desired values of the search attribute. Matching of the attribute values is exact and case
     * insensitive.
     * A maximum of 250 values may be searched in a request.
     *
     * @required
     * @maps attribute_values
     *
     * @param string[] $attributeValues
     */
    public function setAttributeValues(array $attributeValues): void
    {
        $this->attributeValues = $attributeValues;
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
        $json['attribute_name']   = $this->attributeName;
        $json['attribute_values'] = $this->attributeValues;
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
