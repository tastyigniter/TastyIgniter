<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Represents a
 * [CreateCustomerCustomAttributeDefinition]($e/CustomerCustomAttributes/CreateCustomerCustomAttributeD
 * efinition) request.
 */
class CreateCustomerCustomAttributeDefinitionRequest implements \JsonSerializable
{
    /**
     * @var CustomAttributeDefinition
     */
    private $customAttributeDefinition;

    /**
     * @var string|null
     */
    private $idempotencyKey;

    /**
     * @param CustomAttributeDefinition $customAttributeDefinition
     */
    public function __construct(CustomAttributeDefinition $customAttributeDefinition)
    {
        $this->customAttributeDefinition = $customAttributeDefinition;
    }

    /**
     * Returns Custom Attribute Definition.
     * Represents a definition for custom attribute values. A custom attribute definition
     * specifies the key, visibility, schema, and other properties for a custom attribute.
     */
    public function getCustomAttributeDefinition(): CustomAttributeDefinition
    {
        return $this->customAttributeDefinition;
    }

    /**
     * Sets Custom Attribute Definition.
     * Represents a definition for custom attribute values. A custom attribute definition
     * specifies the key, visibility, schema, and other properties for a custom attribute.
     *
     * @required
     * @maps custom_attribute_definition
     */
    public function setCustomAttributeDefinition(CustomAttributeDefinition $customAttributeDefinition): void
    {
        $this->customAttributeDefinition = $customAttributeDefinition;
    }

    /**
     * Returns Idempotency Key.
     * A unique identifier for this request, used to ensure idempotency. For more information,
     * see [Idempotency](https://developer.squareup.com/docs/build-basics/common-api-patterns/idempotency).
     */
    public function getIdempotencyKey(): ?string
    {
        return $this->idempotencyKey;
    }

    /**
     * Sets Idempotency Key.
     * A unique identifier for this request, used to ensure idempotency. For more information,
     * see [Idempotency](https://developer.squareup.com/docs/build-basics/common-api-patterns/idempotency).
     *
     * @maps idempotency_key
     */
    public function setIdempotencyKey(?string $idempotencyKey): void
    {
        $this->idempotencyKey = $idempotencyKey;
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
        $json['custom_attribute_definition'] = $this->customAttributeDefinition;
        if (isset($this->idempotencyKey)) {
            $json['idempotency_key']         = $this->idempotencyKey;
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
