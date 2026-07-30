<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * A batch of catalog objects.
 */
class CatalogObjectBatch implements \JsonSerializable
{
    /**
     * @var CatalogObject[]
     */
    private $objects;

    /**
     * @param CatalogObject[] $objects
     */
    public function __construct(array $objects)
    {
        $this->objects = $objects;
    }

    /**
     * Returns Objects.
     * A list of CatalogObjects belonging to this batch.
     *
     * @return CatalogObject[]
     */
    public function getObjects(): array
    {
        return $this->objects;
    }

    /**
     * Sets Objects.
     * A list of CatalogObjects belonging to this batch.
     *
     * @required
     * @maps objects
     *
     * @param CatalogObject[] $objects
     */
    public function setObjects(array $objects): void
    {
        $this->objects = $objects;
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
        $json['objects'] = $this->objects;
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
