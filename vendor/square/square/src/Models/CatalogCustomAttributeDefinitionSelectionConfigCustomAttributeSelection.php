<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * A named selection for this `SELECTION`-type custom attribute definition.
 */
class CatalogCustomAttributeDefinitionSelectionConfigCustomAttributeSelection implements \JsonSerializable
{
    /**
     * @var array
     */
    private $uid = [];

    /**
     * @var string
     */
    private $name;

    /**
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->name = $name;
    }

    /**
     * Returns Uid.
     * Unique ID set by Square.
     */
    public function getUid(): ?string
    {
        if (count($this->uid) == 0) {
            return null;
        }
        return $this->uid['value'];
    }

    /**
     * Sets Uid.
     * Unique ID set by Square.
     *
     * @maps uid
     */
    public function setUid(?string $uid): void
    {
        $this->uid['value'] = $uid;
    }

    /**
     * Unsets Uid.
     * Unique ID set by Square.
     */
    public function unsetUid(): void
    {
        $this->uid = [];
    }

    /**
     * Returns Name.
     * Selection name, unique within `allowed_selections`.
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Sets Name.
     * Selection name, unique within `allowed_selections`.
     *
     * @required
     * @maps name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
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
        if (!empty($this->uid)) {
            $json['uid'] = $this->uid['value'];
        }
        $json['name']    = $this->name;
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
