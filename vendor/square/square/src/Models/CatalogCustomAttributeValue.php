<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * An instance of a custom attribute. Custom attributes can be defined and
 * added to `ITEM` and `ITEM_VARIATION` type catalog objects.
 * [Read more about custom attributes](https://developer.squareup.com/docs/catalog-api/add-custom-
 * attributes).
 */
class CatalogCustomAttributeValue implements \JsonSerializable
{
    /**
     * @var array
     */
    private $name = [];

    /**
     * @var array
     */
    private $stringValue = [];

    /**
     * @var string|null
     */
    private $customAttributeDefinitionId;

    /**
     * @var string|null
     */
    private $type;

    /**
     * @var array
     */
    private $numberValue = [];

    /**
     * @var array
     */
    private $booleanValue = [];

    /**
     * @var array
     */
    private $selectionUidValues = [];

    /**
     * @var string|null
     */
    private $key;

    /**
     * Returns Name.
     * The name of the custom attribute.
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
     * The name of the custom attribute.
     *
     * @maps name
     */
    public function setName(?string $name): void
    {
        $this->name['value'] = $name;
    }

    /**
     * Unsets Name.
     * The name of the custom attribute.
     */
    public function unsetName(): void
    {
        $this->name = [];
    }

    /**
     * Returns String Value.
     * The string value of the custom attribute.  Populated if `type` = `STRING`.
     */
    public function getStringValue(): ?string
    {
        if (count($this->stringValue) == 0) {
            return null;
        }
        return $this->stringValue['value'];
    }

    /**
     * Sets String Value.
     * The string value of the custom attribute.  Populated if `type` = `STRING`.
     *
     * @maps string_value
     */
    public function setStringValue(?string $stringValue): void
    {
        $this->stringValue['value'] = $stringValue;
    }

    /**
     * Unsets String Value.
     * The string value of the custom attribute.  Populated if `type` = `STRING`.
     */
    public function unsetStringValue(): void
    {
        $this->stringValue = [];
    }

    /**
     * Returns Custom Attribute Definition Id.
     * The id of the [CatalogCustomAttributeDefinition](entity:CatalogCustomAttributeDefinition) this value
     * belongs to.
     */
    public function getCustomAttributeDefinitionId(): ?string
    {
        return $this->customAttributeDefinitionId;
    }

    /**
     * Sets Custom Attribute Definition Id.
     * The id of the [CatalogCustomAttributeDefinition](entity:CatalogCustomAttributeDefinition) this value
     * belongs to.
     *
     * @maps custom_attribute_definition_id
     */
    public function setCustomAttributeDefinitionId(?string $customAttributeDefinitionId): void
    {
        $this->customAttributeDefinitionId = $customAttributeDefinitionId;
    }

    /**
     * Returns Type.
     * Defines the possible types for a custom attribute.
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * Sets Type.
     * Defines the possible types for a custom attribute.
     *
     * @maps type
     */
    public function setType(?string $type): void
    {
        $this->type = $type;
    }

    /**
     * Returns Number Value.
     * Populated if `type` = `NUMBER`. Contains a string
     * representation of a decimal number, using a `.` as the decimal separator.
     */
    public function getNumberValue(): ?string
    {
        if (count($this->numberValue) == 0) {
            return null;
        }
        return $this->numberValue['value'];
    }

    /**
     * Sets Number Value.
     * Populated if `type` = `NUMBER`. Contains a string
     * representation of a decimal number, using a `.` as the decimal separator.
     *
     * @maps number_value
     */
    public function setNumberValue(?string $numberValue): void
    {
        $this->numberValue['value'] = $numberValue;
    }

    /**
     * Unsets Number Value.
     * Populated if `type` = `NUMBER`. Contains a string
     * representation of a decimal number, using a `.` as the decimal separator.
     */
    public function unsetNumberValue(): void
    {
        $this->numberValue = [];
    }

    /**
     * Returns Boolean Value.
     * A `true` or `false` value. Populated if `type` = `BOOLEAN`.
     */
    public function getBooleanValue(): ?bool
    {
        if (count($this->booleanValue) == 0) {
            return null;
        }
        return $this->booleanValue['value'];
    }

    /**
     * Sets Boolean Value.
     * A `true` or `false` value. Populated if `type` = `BOOLEAN`.
     *
     * @maps boolean_value
     */
    public function setBooleanValue(?bool $booleanValue): void
    {
        $this->booleanValue['value'] = $booleanValue;
    }

    /**
     * Unsets Boolean Value.
     * A `true` or `false` value. Populated if `type` = `BOOLEAN`.
     */
    public function unsetBooleanValue(): void
    {
        $this->booleanValue = [];
    }

    /**
     * Returns Selection Uid Values.
     * One or more choices from `allowed_selections`. Populated if `type` = `SELECTION`.
     *
     * @return string[]|null
     */
    public function getSelectionUidValues(): ?array
    {
        if (count($this->selectionUidValues) == 0) {
            return null;
        }
        return $this->selectionUidValues['value'];
    }

    /**
     * Sets Selection Uid Values.
     * One or more choices from `allowed_selections`. Populated if `type` = `SELECTION`.
     *
     * @maps selection_uid_values
     *
     * @param string[]|null $selectionUidValues
     */
    public function setSelectionUidValues(?array $selectionUidValues): void
    {
        $this->selectionUidValues['value'] = $selectionUidValues;
    }

    /**
     * Unsets Selection Uid Values.
     * One or more choices from `allowed_selections`. Populated if `type` = `SELECTION`.
     */
    public function unsetSelectionUidValues(): void
    {
        $this->selectionUidValues = [];
    }

    /**
     * Returns Key.
     * If the associated `CatalogCustomAttributeDefinition` object is defined by another application, this
     * key is prefixed by the defining application ID.
     * For example, if the CatalogCustomAttributeDefinition has a key attribute of "cocoa_brand" and the
     * defining application ID is "abcd1234", this key is "abcd1234:cocoa_brand"
     * when the application making the request is different from the application defining the custom
     * attribute definition. Otherwise, the key is simply "cocoa_brand".
     */
    public function getKey(): ?string
    {
        return $this->key;
    }

    /**
     * Sets Key.
     * If the associated `CatalogCustomAttributeDefinition` object is defined by another application, this
     * key is prefixed by the defining application ID.
     * For example, if the CatalogCustomAttributeDefinition has a key attribute of "cocoa_brand" and the
     * defining application ID is "abcd1234", this key is "abcd1234:cocoa_brand"
     * when the application making the request is different from the application defining the custom
     * attribute definition. Otherwise, the key is simply "cocoa_brand".
     *
     * @maps key
     */
    public function setKey(?string $key): void
    {
        $this->key = $key;
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
        if (!empty($this->name)) {
            $json['name']                           = $this->name['value'];
        }
        if (!empty($this->stringValue)) {
            $json['string_value']                   = $this->stringValue['value'];
        }
        if (isset($this->customAttributeDefinitionId)) {
            $json['custom_attribute_definition_id'] = $this->customAttributeDefinitionId;
        }
        if (isset($this->type)) {
            $json['type']                           = $this->type;
        }
        if (!empty($this->numberValue)) {
            $json['number_value']                   = $this->numberValue['value'];
        }
        if (!empty($this->booleanValue)) {
            $json['boolean_value']                  = $this->booleanValue['value'];
        }
        if (!empty($this->selectionUidValues)) {
            $json['selection_uid_values']           = $this->selectionUidValues['value'];
        }
        if (isset($this->key)) {
            $json['key']                            = $this->key;
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
