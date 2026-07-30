<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Represents a
 * [RetrieveCustomerCustomAttributeDefinition]($e/CustomerCustomAttributes/RetrieveCustomerCustomAttrib
 * uteDefinition) request.
 */
class RetrieveCustomerCustomAttributeDefinitionRequest implements \JsonSerializable
{
    /**
     * @var int|null
     */
    private $version;

    /**
     * Returns Version.
     * The current version of the custom attribute definition, which is used for strongly consistent
     * reads to guarantee that you receive the most up-to-date data. When included in the request,
     * Square returns the specified version or a higher version if one exists. If the specified version
     * is higher than the current version, Square returns a `BAD_REQUEST` error.
     */
    public function getVersion(): ?int
    {
        return $this->version;
    }

    /**
     * Sets Version.
     * The current version of the custom attribute definition, which is used for strongly consistent
     * reads to guarantee that you receive the most up-to-date data. When included in the request,
     * Square returns the specified version or a higher version if one exists. If the specified version
     * is higher than the current version, Square returns a `BAD_REQUEST` error.
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
