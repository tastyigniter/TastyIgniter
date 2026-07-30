<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Supported custom attribute query expressions for calling the
 * [SearchCatalogItems]($e/Catalog/SearchCatalogItems)
 * endpoint to search for items or item variations.
 */
class CustomAttributeFilter implements \JsonSerializable
{
    /**
     * @var array
     */
    private $customAttributeDefinitionId = [];

    /**
     * @var array
     */
    private $key = [];

    /**
     * @var array
     */
    private $stringFilter = [];

    /**
     * @var Range|null
     */
    private $numberFilter;

    /**
     * @var array
     */
    private $selectionUidsFilter = [];

    /**
     * @var array
     */
    private $boolFilter = [];

    /**
     * Returns Custom Attribute Definition Id.
     * A query expression to filter items or item variations by matching their custom attributes'
     * `custom_attribute_definition_id` property value against the the specified id.
     * Exactly one of `custom_attribute_definition_id` or `key` must be specified.
     */
    public function getCustomAttributeDefinitionId(): ?string
    {
        if (count($this->customAttributeDefinitionId) == 0) {
            return null;
        }
        return $this->customAttributeDefinitionId['value'];
    }

    /**
     * Sets Custom Attribute Definition Id.
     * A query expression to filter items or item variations by matching their custom attributes'
     * `custom_attribute_definition_id` property value against the the specified id.
     * Exactly one of `custom_attribute_definition_id` or `key` must be specified.
     *
     * @maps custom_attribute_definition_id
     */
    public function setCustomAttributeDefinitionId(?string $customAttributeDefinitionId): void
    {
        $this->customAttributeDefinitionId['value'] = $customAttributeDefinitionId;
    }

    /**
     * Unsets Custom Attribute Definition Id.
     * A query expression to filter items or item variations by matching their custom attributes'
     * `custom_attribute_definition_id` property value against the the specified id.
     * Exactly one of `custom_attribute_definition_id` or `key` must be specified.
     */
    public function unsetCustomAttributeDefinitionId(): void
    {
        $this->customAttributeDefinitionId = [];
    }

    /**
     * Returns Key.
     * A query expression to filter items or item variations by matching their custom attributes'
     * `key` property value against the specified key.
     * Exactly one of `custom_attribute_definition_id` or `key` must be specified.
     */
    public function getKey(): ?string
    {
        if (count($this->key) == 0) {
            return null;
        }
        return $this->key['value'];
    }

    /**
     * Sets Key.
     * A query expression to filter items or item variations by matching their custom attributes'
     * `key` property value against the specified key.
     * Exactly one of `custom_attribute_definition_id` or `key` must be specified.
     *
     * @maps key
     */
    public function setKey(?string $key): void
    {
        $this->key['value'] = $key;
    }

    /**
     * Unsets Key.
     * A query expression to filter items or item variations by matching their custom attributes'
     * `key` property value against the specified key.
     * Exactly one of `custom_attribute_definition_id` or `key` must be specified.
     */
    public function unsetKey(): void
    {
        $this->key = [];
    }

    /**
     * Returns String Filter.
     * A query expression to filter items or item variations by matching their custom attributes'
     * `string_value`  property value against the specified text.
     * Exactly one of `string_filter`, `number_filter`, `selection_uids_filter`, or `bool_filter` must be
     * specified.
     */
    public function getStringFilter(): ?string
    {
        if (count($this->stringFilter) == 0) {
            return null;
        }
        return $this->stringFilter['value'];
    }

    /**
     * Sets String Filter.
     * A query expression to filter items or item variations by matching their custom attributes'
     * `string_value`  property value against the specified text.
     * Exactly one of `string_filter`, `number_filter`, `selection_uids_filter`, or `bool_filter` must be
     * specified.
     *
     * @maps string_filter
     */
    public function setStringFilter(?string $stringFilter): void
    {
        $this->stringFilter['value'] = $stringFilter;
    }

    /**
     * Unsets String Filter.
     * A query expression to filter items or item variations by matching their custom attributes'
     * `string_value`  property value against the specified text.
     * Exactly one of `string_filter`, `number_filter`, `selection_uids_filter`, or `bool_filter` must be
     * specified.
     */
    public function unsetStringFilter(): void
    {
        $this->stringFilter = [];
    }

    /**
     * Returns Number Filter.
     * The range of a number value between the specified lower and upper bounds.
     */
    public function getNumberFilter(): ?Range
    {
        return $this->numberFilter;
    }

    /**
     * Sets Number Filter.
     * The range of a number value between the specified lower and upper bounds.
     *
     * @maps number_filter
     */
    public function setNumberFilter(?Range $numberFilter): void
    {
        $this->numberFilter = $numberFilter;
    }

    /**
     * Returns Selection Uids Filter.
     * A query expression to filter items or item variations by matching  their custom attributes'
     * `selection_uid_values` values against the specified selection uids.
     * Exactly one of `string_filter`, `number_filter`, `selection_uids_filter`, or `bool_filter` must be
     * specified.
     *
     * @return string[]|null
     */
    public function getSelectionUidsFilter(): ?array
    {
        if (count($this->selectionUidsFilter) == 0) {
            return null;
        }
        return $this->selectionUidsFilter['value'];
    }

    /**
     * Sets Selection Uids Filter.
     * A query expression to filter items or item variations by matching  their custom attributes'
     * `selection_uid_values` values against the specified selection uids.
     * Exactly one of `string_filter`, `number_filter`, `selection_uids_filter`, or `bool_filter` must be
     * specified.
     *
     * @maps selection_uids_filter
     *
     * @param string[]|null $selectionUidsFilter
     */
    public function setSelectionUidsFilter(?array $selectionUidsFilter): void
    {
        $this->selectionUidsFilter['value'] = $selectionUidsFilter;
    }

    /**
     * Unsets Selection Uids Filter.
     * A query expression to filter items or item variations by matching  their custom attributes'
     * `selection_uid_values` values against the specified selection uids.
     * Exactly one of `string_filter`, `number_filter`, `selection_uids_filter`, or `bool_filter` must be
     * specified.
     */
    public function unsetSelectionUidsFilter(): void
    {
        $this->selectionUidsFilter = [];
    }

    /**
     * Returns Bool Filter.
     * A query expression to filter items or item variations by matching their custom attributes'
     * `boolean_value` property values against the specified Boolean expression.
     * Exactly one of `string_filter`, `number_filter`, `selection_uids_filter`, or `bool_filter` must be
     * specified.
     */
    public function getBoolFilter(): ?bool
    {
        if (count($this->boolFilter) == 0) {
            return null;
        }
        return $this->boolFilter['value'];
    }

    /**
     * Sets Bool Filter.
     * A query expression to filter items or item variations by matching their custom attributes'
     * `boolean_value` property values against the specified Boolean expression.
     * Exactly one of `string_filter`, `number_filter`, `selection_uids_filter`, or `bool_filter` must be
     * specified.
     *
     * @maps bool_filter
     */
    public function setBoolFilter(?bool $boolFilter): void
    {
        $this->boolFilter['value'] = $boolFilter;
    }

    /**
     * Unsets Bool Filter.
     * A query expression to filter items or item variations by matching their custom attributes'
     * `boolean_value` property values against the specified Boolean expression.
     * Exactly one of `string_filter`, `number_filter`, `selection_uids_filter`, or `bool_filter` must be
     * specified.
     */
    public function unsetBoolFilter(): void
    {
        $this->boolFilter = [];
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
        if (!empty($this->customAttributeDefinitionId)) {
            $json['custom_attribute_definition_id'] = $this->customAttributeDefinitionId['value'];
        }
        if (!empty($this->key)) {
            $json['key']                            = $this->key['value'];
        }
        if (!empty($this->stringFilter)) {
            $json['string_filter']                  = $this->stringFilter['value'];
        }
        if (isset($this->numberFilter)) {
            $json['number_filter']                  = $this->numberFilter;
        }
        if (!empty($this->selectionUidsFilter)) {
            $json['selection_uids_filter']          = $this->selectionUidsFilter['value'];
        }
        if (!empty($this->boolFilter)) {
            $json['bool_filter']                    = $this->boolFilter['value'];
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
