<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Represents a get request for an order custom attribute.
 */
class RetrieveOrderCustomAttributeRequest implements \JsonSerializable
{
    /**
     * @var int|null
     */
    private $version;

    /**
     * @var array
     */
    private $withDefinition = [];

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
     * Returns With Definition.
     * Indicates whether to return the [custom attribute definition](entity:CustomAttributeDefinition) in
     * the `definition` field of each
     * custom attribute. Set this parameter to `true` to get the name and description of each custom
     * attribute,
     * information about the data type, or other definition details. The default value is `false`.
     */
    public function getWithDefinition(): ?bool
    {
        if (count($this->withDefinition) == 0) {
            return null;
        }
        return $this->withDefinition['value'];
    }

    /**
     * Sets With Definition.
     * Indicates whether to return the [custom attribute definition](entity:CustomAttributeDefinition) in
     * the `definition` field of each
     * custom attribute. Set this parameter to `true` to get the name and description of each custom
     * attribute,
     * information about the data type, or other definition details. The default value is `false`.
     *
     * @maps with_definition
     */
    public function setWithDefinition(?bool $withDefinition): void
    {
        $this->withDefinition['value'] = $withDefinition;
    }

    /**
     * Unsets With Definition.
     * Indicates whether to return the [custom attribute definition](entity:CustomAttributeDefinition) in
     * the `definition` field of each
     * custom attribute. Set this parameter to `true` to get the name and description of each custom
     * attribute,
     * information about the data type, or other definition details. The default value is `false`.
     */
    public function unsetWithDefinition(): void
    {
        $this->withDefinition = [];
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
            $json['version']         = $this->version;
        }
        if (!empty($this->withDefinition)) {
            $json['with_definition'] = $this->withDefinition['value'];
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
