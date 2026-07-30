<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Configuration associated with `SELECTION`-type custom attribute definitions.
 */
class CatalogCustomAttributeDefinitionSelectionConfig implements \JsonSerializable
{
    /**
     * @var array
     */
    private $maxAllowedSelections = [];

    /**
     * @var array
     */
    private $allowedSelections = [];

    /**
     * Returns Max Allowed Selections.
     * The maximum number of selections that can be set. The maximum value for this
     * attribute is 100. The default value is 1. The value can be modified, but changing the value will
     * not
     * affect existing custom attribute values on objects. Clients need to
     * handle custom attributes with more selected values than allowed by this limit.
     */
    public function getMaxAllowedSelections(): ?int
    {
        if (count($this->maxAllowedSelections) == 0) {
            return null;
        }
        return $this->maxAllowedSelections['value'];
    }

    /**
     * Sets Max Allowed Selections.
     * The maximum number of selections that can be set. The maximum value for this
     * attribute is 100. The default value is 1. The value can be modified, but changing the value will
     * not
     * affect existing custom attribute values on objects. Clients need to
     * handle custom attributes with more selected values than allowed by this limit.
     *
     * @maps max_allowed_selections
     */
    public function setMaxAllowedSelections(?int $maxAllowedSelections): void
    {
        $this->maxAllowedSelections['value'] = $maxAllowedSelections;
    }

    /**
     * Unsets Max Allowed Selections.
     * The maximum number of selections that can be set. The maximum value for this
     * attribute is 100. The default value is 1. The value can be modified, but changing the value will
     * not
     * affect existing custom attribute values on objects. Clients need to
     * handle custom attributes with more selected values than allowed by this limit.
     */
    public function unsetMaxAllowedSelections(): void
    {
        $this->maxAllowedSelections = [];
    }

    /**
     * Returns Allowed Selections.
     * The set of valid `CatalogCustomAttributeSelections`. Up to a maximum of 100
     * selections can be defined. Can be modified.
     *
     * @return CatalogCustomAttributeDefinitionSelectionConfigCustomAttributeSelection[]|null
     */
    public function getAllowedSelections(): ?array
    {
        if (count($this->allowedSelections) == 0) {
            return null;
        }
        return $this->allowedSelections['value'];
    }

    /**
     * Sets Allowed Selections.
     * The set of valid `CatalogCustomAttributeSelections`. Up to a maximum of 100
     * selections can be defined. Can be modified.
     *
     * @maps allowed_selections
     *
     * @param CatalogCustomAttributeDefinitionSelectionConfigCustomAttributeSelection[]|null $allowedSelections
     */
    public function setAllowedSelections(?array $allowedSelections): void
    {
        $this->allowedSelections['value'] = $allowedSelections;
    }

    /**
     * Unsets Allowed Selections.
     * The set of valid `CatalogCustomAttributeSelections`. Up to a maximum of 100
     * selections can be defined. Can be modified.
     */
    public function unsetAllowedSelections(): void
    {
        $this->allowedSelections = [];
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
        if (!empty($this->maxAllowedSelections)) {
            $json['max_allowed_selections'] = $this->maxAllowedSelections['value'];
        }
        if (!empty($this->allowedSelections)) {
            $json['allowed_selections']     = $this->allowedSelections['value'];
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
