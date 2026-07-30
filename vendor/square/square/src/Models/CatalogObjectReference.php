<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * A reference to a Catalog object at a specific version. In general this is
 * used as an entry point into a graph of catalog objects, where the objects exist
 * at a specific version.
 */
class CatalogObjectReference implements \JsonSerializable
{
    /**
     * @var array
     */
    private $objectId = [];

    /**
     * @var array
     */
    private $catalogVersion = [];

    /**
     * Returns Object Id.
     * The ID of the referenced object.
     */
    public function getObjectId(): ?string
    {
        if (count($this->objectId) == 0) {
            return null;
        }
        return $this->objectId['value'];
    }

    /**
     * Sets Object Id.
     * The ID of the referenced object.
     *
     * @maps object_id
     */
    public function setObjectId(?string $objectId): void
    {
        $this->objectId['value'] = $objectId;
    }

    /**
     * Unsets Object Id.
     * The ID of the referenced object.
     */
    public function unsetObjectId(): void
    {
        $this->objectId = [];
    }

    /**
     * Returns Catalog Version.
     * The version of the object.
     */
    public function getCatalogVersion(): ?int
    {
        if (count($this->catalogVersion) == 0) {
            return null;
        }
        return $this->catalogVersion['value'];
    }

    /**
     * Sets Catalog Version.
     * The version of the object.
     *
     * @maps catalog_version
     */
    public function setCatalogVersion(?int $catalogVersion): void
    {
        $this->catalogVersion['value'] = $catalogVersion;
    }

    /**
     * Unsets Catalog Version.
     * The version of the object.
     */
    public function unsetCatalogVersion(): void
    {
        $this->catalogVersion = [];
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
        if (!empty($this->objectId)) {
            $json['object_id']       = $this->objectId['value'];
        }
        if (!empty($this->catalogVersion)) {
            $json['catalog_version'] = $this->catalogVersion['value'];
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
