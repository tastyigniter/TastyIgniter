<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

class RetrieveCatalogObjectRequest implements \JsonSerializable
{
    /**
     * @var array
     */
    private $includeRelatedObjects = [];

    /**
     * @var array
     */
    private $catalogVersion = [];

    /**
     * Returns Include Related Objects.
     * If `true`, the response will include additional objects that are related to the
     * requested objects. Related objects are defined as any objects referenced by ID by the results in the
     * `objects` field
     * of the response. These objects are put in the `related_objects` field. Setting this to `true` is
     * helpful when the objects are needed for immediate display to a user.
     * This process only goes one level deep. Objects referenced by the related objects will not be
     * included. For example,
     *
     * if the `objects` field of the response contains a CatalogItem, its associated
     * CatalogCategory objects, CatalogTax objects, CatalogImage objects and
     * CatalogModifierLists will be returned in the `related_objects` field of the
     * response. If the `objects` field of the response contains a CatalogItemVariation,
     * its parent CatalogItem will be returned in the `related_objects` field of
     * the response.
     *
     * Default value: `false`
     */
    public function getIncludeRelatedObjects(): ?bool
    {
        if (count($this->includeRelatedObjects) == 0) {
            return null;
        }
        return $this->includeRelatedObjects['value'];
    }

    /**
     * Sets Include Related Objects.
     * If `true`, the response will include additional objects that are related to the
     * requested objects. Related objects are defined as any objects referenced by ID by the results in the
     * `objects` field
     * of the response. These objects are put in the `related_objects` field. Setting this to `true` is
     * helpful when the objects are needed for immediate display to a user.
     * This process only goes one level deep. Objects referenced by the related objects will not be
     * included. For example,
     *
     * if the `objects` field of the response contains a CatalogItem, its associated
     * CatalogCategory objects, CatalogTax objects, CatalogImage objects and
     * CatalogModifierLists will be returned in the `related_objects` field of the
     * response. If the `objects` field of the response contains a CatalogItemVariation,
     * its parent CatalogItem will be returned in the `related_objects` field of
     * the response.
     *
     * Default value: `false`
     *
     * @maps include_related_objects
     */
    public function setIncludeRelatedObjects(?bool $includeRelatedObjects): void
    {
        $this->includeRelatedObjects['value'] = $includeRelatedObjects;
    }

    /**
     * Unsets Include Related Objects.
     * If `true`, the response will include additional objects that are related to the
     * requested objects. Related objects are defined as any objects referenced by ID by the results in the
     * `objects` field
     * of the response. These objects are put in the `related_objects` field. Setting this to `true` is
     * helpful when the objects are needed for immediate display to a user.
     * This process only goes one level deep. Objects referenced by the related objects will not be
     * included. For example,
     *
     * if the `objects` field of the response contains a CatalogItem, its associated
     * CatalogCategory objects, CatalogTax objects, CatalogImage objects and
     * CatalogModifierLists will be returned in the `related_objects` field of the
     * response. If the `objects` field of the response contains a CatalogItemVariation,
     * its parent CatalogItem will be returned in the `related_objects` field of
     * the response.
     *
     * Default value: `false`
     */
    public function unsetIncludeRelatedObjects(): void
    {
        $this->includeRelatedObjects = [];
    }

    /**
     * Returns Catalog Version.
     * Requests objects as of a specific version of the catalog. This allows you to retrieve historical
     * versions of objects. The value to retrieve a specific version of an object can be found
     * in the version field of [CatalogObject]($m/CatalogObject)s. If not included, results will
     * be from the current version of the catalog.
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
     * Requests objects as of a specific version of the catalog. This allows you to retrieve historical
     * versions of objects. The value to retrieve a specific version of an object can be found
     * in the version field of [CatalogObject]($m/CatalogObject)s. If not included, results will
     * be from the current version of the catalog.
     *
     * @maps catalog_version
     */
    public function setCatalogVersion(?int $catalogVersion): void
    {
        $this->catalogVersion['value'] = $catalogVersion;
    }

    /**
     * Unsets Catalog Version.
     * Requests objects as of a specific version of the catalog. This allows you to retrieve historical
     * versions of objects. The value to retrieve a specific version of an object can be found
     * in the version field of [CatalogObject]($m/CatalogObject)s. If not included, results will
     * be from the current version of the catalog.
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
        if (!empty($this->includeRelatedObjects)) {
            $json['include_related_objects'] = $this->includeRelatedObjects['value'];
        }
        if (!empty($this->catalogVersion)) {
            $json['catalog_version']         = $this->catalogVersion['value'];
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
