<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Represents a
 * [RetrieveCustomerCustomAttribute]($e/CustomerCustomAttributes/RetrieveCustomerCustomAttribute)
 * request.
 */
class RetrieveCustomerCustomAttributeRequest implements \JsonSerializable
{
    /**
     * @var array
     */
    private $withDefinition = [];

    /**
     * @var int|null
     */
    private $version;

    /**
     * Returns With Definition.
     * Indicates whether to return the [custom attribute definition](entity:CustomAttributeDefinition) in
     * the `definition` field of
     * the custom attribute. Set this parameter to `true` to get the name and description of the custom
     * attribute, information about the data type, or other definition details. The default value is
     * `false`.
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
     * the `definition` field of
     * the custom attribute. Set this parameter to `true` to get the name and description of the custom
     * attribute, information about the data type, or other definition details. The default value is
     * `false`.
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
     * the `definition` field of
     * the custom attribute. Set this parameter to `true` to get the name and description of the custom
     * attribute, information about the data type, or other definition details. The default value is
     * `false`.
     */
    public function unsetWithDefinition(): void
    {
        $this->withDefinition = [];
    }

    /**
     * Returns Version.
     * The current version of the custom attribute, which is used for strongly consistent reads to
     * guarantee that you receive the most up-to-date data. When included in the request, Square
     * returns the specified version or a higher version if one exists. If the specified version is
     * higher than the current version, Square returns a `BAD_REQUEST` error.
     */
    public function getVersion(): ?int
    {
        return $this->version;
    }

    /**
     * Sets Version.
     * The current version of the custom attribute, which is used for strongly consistent reads to
     * guarantee that you receive the most up-to-date data. When included in the request, Square
     * returns the specified version or a higher version if one exists. If the specified version is
     * higher than the current version, Square returns a `BAD_REQUEST` error.
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
        if (!empty($this->withDefinition)) {
            $json['with_definition'] = $this->withDefinition['value'];
        }
        if (isset($this->version)) {
            $json['version']         = $this->version;
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
