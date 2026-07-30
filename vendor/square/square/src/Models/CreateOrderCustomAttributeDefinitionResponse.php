<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Represents a response from creating an order custom attribute definition.
 */
class CreateOrderCustomAttributeDefinitionResponse implements \JsonSerializable
{
    /**
     * @var CustomAttributeDefinition|null
     */
    private $customAttributeDefinition;

    /**
     * @var Error[]|null
     */
    private $errors;

    /**
     * Returns Custom Attribute Definition.
     * Represents a definition for custom attribute values. A custom attribute definition
     * specifies the key, visibility, schema, and other properties for a custom attribute.
     */
    public function getCustomAttributeDefinition(): ?CustomAttributeDefinition
    {
        return $this->customAttributeDefinition;
    }

    /**
     * Sets Custom Attribute Definition.
     * Represents a definition for custom attribute values. A custom attribute definition
     * specifies the key, visibility, schema, and other properties for a custom attribute.
     *
     * @maps custom_attribute_definition
     */
    public function setCustomAttributeDefinition(?CustomAttributeDefinition $customAttributeDefinition): void
    {
        $this->customAttributeDefinition = $customAttributeDefinition;
    }

    /**
     * Returns Errors.
     * Any errors that occurred during the request.
     *
     * @return Error[]|null
     */
    public function getErrors(): ?array
    {
        return $this->errors;
    }

    /**
     * Sets Errors.
     * Any errors that occurred during the request.
     *
     * @maps errors
     *
     * @param Error[]|null $errors
     */
    public function setErrors(?array $errors): void
    {
        $this->errors = $errors;
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
        if (isset($this->customAttributeDefinition)) {
            $json['custom_attribute_definition'] = $this->customAttributeDefinition;
        }
        if (isset($this->errors)) {
            $json['errors']                      = $this->errors;
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
