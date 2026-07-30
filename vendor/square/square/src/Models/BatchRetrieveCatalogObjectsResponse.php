<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

class BatchRetrieveCatalogObjectsResponse implements \JsonSerializable
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
     * @var CatalogObject[]|null
     */
    private $relatedObjects;

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
     * A list of [CatalogObject](entity:CatalogObject)s returned.
     *
     * @return CatalogObject[]|null
     */
    public function getObjects(): ?array
    {
        return $this->objects;
    }

    /**
     * Sets Objects.
     * A list of [CatalogObject](entity:CatalogObject)s returned.
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
     * Returns Related Objects.
     * A list of [CatalogObject](entity:CatalogObject)s referenced by the object in the `objects` field.
     *
     * @return CatalogObject[]|null
     */
    public function getRelatedObjects(): ?array
    {
        return $this->relatedObjects;
    }

    /**
     * Sets Related Objects.
     * A list of [CatalogObject](entity:CatalogObject)s referenced by the object in the `objects` field.
     *
     * @maps related_objects
     *
     * @param CatalogObject[]|null $relatedObjects
     */
    public function setRelatedObjects(?array $relatedObjects): void
    {
        $this->relatedObjects = $relatedObjects;
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
            $json['errors']          = $this->errors;
        }
        if (isset($this->objects)) {
            $json['objects']         = $this->objects;
        }
        if (isset($this->relatedObjects)) {
            $json['related_objects'] = $this->relatedObjects;
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
