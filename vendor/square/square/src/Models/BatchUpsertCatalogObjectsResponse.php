<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

class BatchUpsertCatalogObjectsResponse implements \JsonSerializable
{
    /**
     * @var Error[]|null
     */
    private $errors;

    /**
     * @var CatalogObject[]|null
     */
    private $objects;

    /**
     * @var string|null
     */
    private $updatedAt;

    /**
     * @var CatalogIdMapping[]|null
     */
    private $idMappings;

    /**
     * Returns Errors.
     * Any errors that occurred during the request.
     *
     * @return Error[]|null
     */
    public function getErrors(): ?array
    {
        return $this->errors;
    }

    /**
     * Sets Errors.
     * Any errors that occurred during the request.
     *
     * @maps errors
     *
     * @param Error[]|null $errors
     */
    public function setErrors(?array $errors): void
    {
        $this->errors = $errors;
    }

    /**
     * Returns Objects.
     * The created successfully created CatalogObjects.
     *
     * @return CatalogObject[]|null
     */
    public function getObjects(): ?array
    {
        return $this->objects;
    }

    /**
     * Sets Objects.
     * The created successfully created CatalogObjects.
     *
     * @maps objects
     *
     * @param CatalogObject[]|null $objects
     */
    public function setObjects(?array $objects): void
    {
        $this->objects = $objects;
    }

    /**
     * Returns Updated At.
     * The database [timestamp](https://developer.squareup.com/docs/build-basics/working-with-dates) of
     * this update in RFC 3339 format, e.g., "2016-09-04T23:59:33.123Z".
     */
    public function getUpdatedAt(): ?string
    {
        return $this->updatedAt;
    }

    /**
     * Sets Updated At.
     * The database [timestamp](https://developer.squareup.com/docs/build-basics/working-with-dates) of
     * this update in RFC 3339 format, e.g., "2016-09-04T23:59:33.123Z".
     *
     * @maps updated_at
     */
    public function setUpdatedAt(?string $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * Returns Id Mappings.
     * The mapping between client and server IDs for this upsert.
     *
     * @return CatalogIdMapping[]|null
     */
    public function getIdMappings(): ?array
    {
        return $this->idMappings;
    }

    /**
     * Sets Id Mappings.
     * The mapping between client and server IDs for this upsert.
     *
     * @maps id_mappings
     *
     * @param CatalogIdMapping[]|null $idMappings
     */
    public function setIdMappings(?array $idMappings): void
    {
        $this->idMappings = $idMappings;
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
        if (isset($this->errors)) {
            $json['errors']      = $this->errors;
        }
        if (isset($this->objects)) {
            $json['objects']     = $this->objects;
        }
        if (isset($this->updatedAt)) {
            $json['updated_at']  = $this->updatedAt;
        }
        if (isset($this->idMappings)) {
            $json['id_mappings'] = $this->idMappings;
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
