<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * A mapping between a temporary client-supplied ID and a permanent server-generated ID.
 *
 * When calling [UpsertCatalogObject]($e/Catalog/UpsertCatalogObject) or
 * [BatchUpsertCatalogObjects]($e/Catalog/BatchUpsertCatalogObjects) to
 * create a [CatalogObject]($m/CatalogObject) instance, you can supply
 * a temporary ID for the to-be-created object, especially when the object is to be referenced
 * elsewhere in the same request body. This temporary ID can be any string unique within
 * the call, but must be prefixed by "#".
 *
 * After the request is submitted and the object created, a permanent server-generated ID is assigned
 * to the new object. The permanent ID is unique across the Square catalog.
 */
class CatalogIdMapping implements \JsonSerializable
{
    /**
     * @var array
     */
    private $clientObjectId = [];

    /**
     * @var array
     */
    private $objectId = [];

    /**
     * Returns Client Object Id.
     * The client-supplied temporary `#`-prefixed ID for a new `CatalogObject`.
     */
    public function getClientObjectId(): ?string
    {
        if (count($this->clientObjectId) == 0) {
            return null;
        }
        return $this->clientObjectId['value'];
    }

    /**
     * Sets Client Object Id.
     * The client-supplied temporary `#`-prefixed ID for a new `CatalogObject`.
     *
     * @maps client_object_id
     */
    public function setClientObjectId(?string $clientObjectId): void
    {
        $this->clientObjectId['value'] = $clientObjectId;
    }

    /**
     * Unsets Client Object Id.
     * The client-supplied temporary `#`-prefixed ID for a new `CatalogObject`.
     */
    public function unsetClientObjectId(): void
    {
        $this->clientObjectId = [];
    }

    /**
     * Returns Object Id.
     * The permanent ID for the CatalogObject created by the server.
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
     * The permanent ID for the CatalogObject created by the server.
     *
     * @maps object_id
     */
    public function setObjectId(?string $objectId): void
    {
        $this->objectId['value'] = $objectId;
    }

    /**
     * Unsets Object Id.
     * The permanent ID for the CatalogObject created by the server.
     */
    public function unsetObjectId(): void
    {
        $this->objectId = [];
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
        if (!empty($this->clientObjectId)) {
            $json['client_object_id'] = $this->clientObjectId['value'];
        }
        if (!empty($this->objectId)) {
            $json['object_id']        = $this->objectId['value'];
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
