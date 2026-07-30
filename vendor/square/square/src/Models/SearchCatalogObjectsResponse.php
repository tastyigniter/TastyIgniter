<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

class SearchCatalogObjectsResponse implements \JsonSerializable
{
    /**
     * @var Error[]|null
     */
    private $errors;

    /**
     * @var string|null
     */
    private $cursor;

    /**
     * @var CatalogObject[]|null
     */
    private $objects;

    /**
     * @var CatalogObject[]|null
     */
    private $relatedObjects;

    /**
     * @var string|null
     */
    private $latestTime;

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
     * Returns Cursor.
     * The pagination cursor to be used in a subsequent request. If unset, this is the final response.
     * See [Pagination](https://developer.squareup.com/docs/build-basics/common-api-patterns/pagination)
     * for more information.
     */
    public function getCursor(): ?string
    {
        return $this->cursor;
    }

    /**
     * Sets Cursor.
     * The pagination cursor to be used in a subsequent request. If unset, this is the final response.
     * See [Pagination](https://developer.squareup.com/docs/build-basics/common-api-patterns/pagination)
     * for more information.
     *
     * @maps cursor
     */
    public function setCursor(?string $cursor): void
    {
        $this->cursor = $cursor;
    }

    /**
     * Returns Objects.
     * The CatalogObjects returned.
     *
     * @return CatalogObject[]|null
     */
    public function getObjects(): ?array
    {
        return $this->objects;
    }

    /**
     * Sets Objects.
     * The CatalogObjects returned.
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
     * A list of CatalogObjects referenced by the objects in the `objects` field.
     *
     * @return CatalogObject[]|null
     */
    public function getRelatedObjects(): ?array
    {
        return $this->relatedObjects;
    }

    /**
     * Sets Related Objects.
     * A list of CatalogObjects referenced by the objects in the `objects` field.
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
     * Returns Latest Time.
     * When the associated product catalog was last updated. Will
     * match the value for `end_time` or `cursor` if either field is included in the `SearchCatalog`
     * request.
     */
    public function getLatestTime(): ?string
    {
        return $this->latestTime;
    }

    /**
     * Sets Latest Time.
     * When the associated product catalog was last updated. Will
     * match the value for `end_time` or `cursor` if either field is included in the `SearchCatalog`
     * request.
     *
     * @maps latest_time
     */
    public function setLatestTime(?string $latestTime): void
    {
        $this->latestTime = $latestTime;
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
        if (isset($this->cursor)) {
            $json['cursor']          = $this->cursor;
        }
        if (isset($this->objects)) {
            $json['objects']         = $this->objects;
        }
        if (isset($this->relatedObjects)) {
            $json['related_objects'] = $this->relatedObjects;
        }
        if (isset($this->latestTime)) {
            $json['latest_time']     = $this->latestTime;
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
