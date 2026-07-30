<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * A Square API V1 identifier of an item, including the object ID and its associated location ID.
 */
class CatalogV1Id implements \JsonSerializable
{
    /**
     * @var array
     */
    private $catalogV1Id = [];

    /**
     * @var array
     */
    private $locationId = [];

    /**
     * Returns Catalog V1 Id.
     * The ID for an object used in the Square API V1, if the object ID differs from the Square API V2
     * object ID.
     */
    public function getCatalogV1Id(): ?string
    {
        if (count($this->catalogV1Id) == 0) {
            return null;
        }
        return $this->catalogV1Id['value'];
    }

    /**
     * Sets Catalog V1 Id.
     * The ID for an object used in the Square API V1, if the object ID differs from the Square API V2
     * object ID.
     *
     * @maps catalog_v1_id
     */
    public function setCatalogV1Id(?string $catalogV1Id): void
    {
        $this->catalogV1Id['value'] = $catalogV1Id;
    }

    /**
     * Unsets Catalog V1 Id.
     * The ID for an object used in the Square API V1, if the object ID differs from the Square API V2
     * object ID.
     */
    public function unsetCatalogV1Id(): void
    {
        $this->catalogV1Id = [];
    }

    /**
     * Returns Location Id.
     * The ID of the `Location` this Connect V1 ID is associated with.
     */
    public function getLocationId(): ?string
    {
        if (count($this->locationId) == 0) {
            return null;
        }
        return $this->locationId['value'];
    }

    /**
     * Sets Location Id.
     * The ID of the `Location` this Connect V1 ID is associated with.
     *
     * @maps location_id
     */
    public function setLocationId(?string $locationId): void
    {
        $this->locationId['value'] = $locationId;
    }

    /**
     * Unsets Location Id.
     * The ID of the `Location` this Connect V1 ID is associated with.
     */
    public function unsetLocationId(): void
    {
        $this->locationId = [];
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
        if (!empty($this->catalogV1Id)) {
            $json['catalog_v1_id'] = $this->catalogV1Id['value'];
        }
        if (!empty($this->locationId)) {
            $json['location_id']   = $this->locationId['value'];
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
