<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Represents an
 * [UpsertLocationCustomAttribute]($e/LocationCustomAttributes/UpsertLocationCustomAttribute) request.
 */
class UpsertLocationCustomAttributeRequest implements \JsonSerializable
{
    /**
     * @var CustomAttribute
     */
    private $customAttribute;

    /**
     * @var array
     */
    private $idempotencyKey = [];

    /**
     * @param CustomAttribute $customAttribute
     */
    public function __construct(CustomAttribute $customAttribute)
    {
        $this->customAttribute = $customAttribute;
    }

    /**
     * Returns Custom Attribute.
     * A custom attribute value. Each custom attribute value has a corresponding
     * `CustomAttributeDefinition` object.
     */
    public function getCustomAttribute(): CustomAttribute
    {
        return $this->customAttribute;
    }

    /**
     * Sets Custom Attribute.
     * A custom attribute value. Each custom attribute value has a corresponding
     * `CustomAttributeDefinition` object.
     *
     * @required
     * @maps custom_attribute
     */
    public function setCustomAttribute(CustomAttribute $customAttribute): void
    {
        $this->customAttribute = $customAttribute;
    }

    /**
     * Returns Idempotency Key.
     * A unique identifier for this request, used to ensure idempotency. For more information,
     * see [Idempotency](https://developer.squareup.com/docs/build-basics/common-api-patterns/idempotency).
     */
    public function getIdempotencyKey(): ?string
    {
        if (count($this->idempotencyKey) == 0) {
            return null;
        }
        return $this->idempotencyKey['value'];
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
        $this->idempotencyKey['value'] = $idempotencyKey;
    }

    /**
     * Unsets Idempotency Key.
     * A unique identifier for this request, used to ensure idempotency. For more information,
     * see [Idempotency](https://developer.squareup.com/docs/build-basics/common-api-patterns/idempotency).
     */
    public function unsetIdempotencyKey(): void
    {
        $this->idempotencyKey = [];
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
        $json['custom_attribute']    = $this->customAttribute;
        if (!empty($this->idempotencyKey)) {
            $json['idempotency_key'] = $this->idempotencyKey['value'];
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
