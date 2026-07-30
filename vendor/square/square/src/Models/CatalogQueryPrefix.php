<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * The query filter to return the search result whose named attribute values are prefixed by the
 * specified attribute value.
 */
class CatalogQueryPrefix implements \JsonSerializable
{
    /**
     * @var string
     */
    private $attributeName;

    /**
     * @var string
     */
    private $attributePrefix;

    /**
     * @param string $attributeName
     * @param string $attributePrefix
     */
    public function __construct(string $attributeName, string $attributePrefix)
    {
        $this->attributeName = $attributeName;
        $this->attributePrefix = $attributePrefix;
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
     * Returns Attribute Prefix.
     * The desired prefix of the search attribute value.
     */
    public function getAttributePrefix(): string
    {
        return $this->attributePrefix;
    }

    /**
     * Sets Attribute Prefix.
     * The desired prefix of the search attribute value.
     *
     * @required
     * @maps attribute_prefix
     */
    public function setAttributePrefix(string $attributePrefix): void
    {
        $this->attributePrefix = $attributePrefix;
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
        $json['attribute_prefix'] = $this->attributePrefix;
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
