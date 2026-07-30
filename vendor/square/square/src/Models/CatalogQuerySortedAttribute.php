<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * The query expression to specify the key to sort search results.
 */
class CatalogQuerySortedAttribute implements \JsonSerializable
{
    /**
     * @var string
     */
    private $attributeName;

    /**
     * @var array
     */
    private $initialAttributeValue = [];

    /**
     * @var string|null
     */
    private $sortOrder;

    /**
     * @param string $attributeName
     */
    public function __construct(string $attributeName)
    {
        $this->attributeName = $attributeName;
    }

    /**
     * Returns Attribute Name.
     * The attribute whose value is used as the sort key.
     */
    public function getAttributeName(): string
    {
        return $this->attributeName;
    }

    /**
     * Sets Attribute Name.
     * The attribute whose value is used as the sort key.
     *
     * @required
     * @maps attribute_name
     */
    public function setAttributeName(string $attributeName): void
    {
        $this->attributeName = $attributeName;
    }

    /**
     * Returns Initial Attribute Value.
     * The first attribute value to be returned by the query. Ascending sorts will return only
     * objects with this value or greater, while descending sorts will return only objects with this value
     * or less. If unset, start at the beginning (for ascending sorts) or end (for descending sorts).
     */
    public function getInitialAttributeValue(): ?string
    {
        if (count($this->initialAttributeValue) == 0) {
            return null;
        }
        return $this->initialAttributeValue['value'];
    }

    /**
     * Sets Initial Attribute Value.
     * The first attribute value to be returned by the query. Ascending sorts will return only
     * objects with this value or greater, while descending sorts will return only objects with this value
     * or less. If unset, start at the beginning (for ascending sorts) or end (for descending sorts).
     *
     * @maps initial_attribute_value
     */
    public function setInitialAttributeValue(?string $initialAttributeValue): void
    {
        $this->initialAttributeValue['value'] = $initialAttributeValue;
    }

    /**
     * Unsets Initial Attribute Value.
     * The first attribute value to be returned by the query. Ascending sorts will return only
     * objects with this value or greater, while descending sorts will return only objects with this value
     * or less. If unset, start at the beginning (for ascending sorts) or end (for descending sorts).
     */
    public function unsetInitialAttributeValue(): void
    {
        $this->initialAttributeValue = [];
    }

    /**
     * Returns Sort Order.
     * The order (e.g., chronological or alphabetical) in which results from a request are returned.
     */
    public function getSortOrder(): ?string
    {
        return $this->sortOrder;
    }

    /**
     * Sets Sort Order.
     * The order (e.g., chronological or alphabetical) in which results from a request are returned.
     *
     * @maps sort_order
     */
    public function setSortOrder(?string $sortOrder): void
    {
        $this->sortOrder = $sortOrder;
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
        $json['attribute_name']              = $this->attributeName;
        if (!empty($this->initialAttributeValue)) {
            $json['initial_attribute_value'] = $this->initialAttributeValue['value'];
        }
        if (isset($this->sortOrder)) {
            $json['sort_order']              = $this->sortOrder;
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
