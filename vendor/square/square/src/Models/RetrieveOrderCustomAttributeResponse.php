<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Represents a response from getting an order custom attribute.
 */
class RetrieveOrderCustomAttributeResponse implements \JsonSerializable
{
    /**
     * @var CustomAttribute|null
     */
    private $customAttribute;

    /**
     * @var Error[]|null
     */
    private $errors;

    /**
     * Returns Custom Attribute.
     * A custom attribute value. Each custom attribute value has a corresponding
     * `CustomAttributeDefinition` object.
     */
    public function getCustomAttribute(): ?CustomAttribute
    {
        return $this->customAttribute;
    }

    /**
     * Sets Custom Attribute.
     * A custom attribute value. Each custom attribute value has a corresponding
     * `CustomAttributeDefinition` object.
     *
     * @maps custom_attribute
     */
    public function setCustomAttribute(?CustomAttribute $customAttribute): void
    {
        $this->customAttribute = $customAttribute;
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
        if (isset($this->customAttribute)) {
            $json['custom_attribute'] = $this->customAttribute;
        }
        if (isset($this->errors)) {
            $json['errors']           = $this->errors;
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
