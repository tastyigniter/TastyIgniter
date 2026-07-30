<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Represents a get request for an order custom attribute definition.
 */
class RetrieveOrderCustomAttributeDefinitionRequest implements \JsonSerializable
{
    /**
     * @var int|null
     */
    private $version;

    /**
     * Returns Version.
     * To enable [optimistic concurrency](https://developer.squareup.com/docs/build-basics/common-api-
     * patterns/optimistic-concurrency)
     * control, include this optional field and specify the current version of the custom attribute.
     */
    public function getVersion(): ?int
    {
        return $this->version;
    }

    /**
     * Sets Version.
     * To enable [optimistic concurrency](https://developer.squareup.com/docs/build-basics/common-api-
     * patterns/optimistic-concurrency)
     * control, include this optional field and specify the current version of the custom attribute.
     *
     * @maps version
     */
    public function setVersion(?int $version): void
    {
        $this->version = $version;
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
        if (isset($this->version)) {
            $json['version'] = $this->version;
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
