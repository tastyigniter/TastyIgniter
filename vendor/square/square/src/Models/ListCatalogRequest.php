<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

class ListCatalogRequest implements \JsonSerializable
{
    /**
     * @var array
     */
    private $cursor = [];

    /**
     * @var array
     */
    private $types = [];

    /**
     * @var array
     */
    private $catalogVersion = [];

    /**
     * Returns Cursor.
     * The pagination cursor returned in the previous response. Leave unset for an initial request.
     * The page size is currently set to be 100.
     * See [Pagination](https://developer.squareup.com/docs/build-basics/common-api-patterns/pagination)
     * for more information.
     */
    public function getCursor(): ?string
    {
        if (count($this->cursor) == 0) {
            return null;
        }
        return $this->cursor['value'];
    }

    /**
     * Sets Cursor.
     * The pagination cursor returned in the previous response. Leave unset for an initial request.
     * The page size is currently set to be 100.
     * See [Pagination](https://developer.squareup.com/docs/build-basics/common-api-patterns/pagination)
     * for more information.
     *
     * @maps cursor
     */
    public function setCursor(?string $cursor): void
    {
        $this->cursor['value'] = $cursor;
    }

    /**
     * Unsets Cursor.
     * The pagination cursor returned in the previous response. Leave unset for an initial request.
     * The page size is currently set to be 100.
     * See [Pagination](https://developer.squareup.com/docs/build-basics/common-api-patterns/pagination)
     * for more information.
     */
    public function unsetCursor(): void
    {
        $this->cursor = [];
    }

    /**
     * Returns Types.
     * An optional case-insensitive, comma-separated list of object types to retrieve.
     *
     * The valid values are defined in the [CatalogObjectType](entity:CatalogObjectType) enum, for example,
     * `ITEM`, `ITEM_VARIATION`, `CATEGORY`, `DISCOUNT`, `TAX`,
     * `MODIFIER`, `MODIFIER_LIST`, `IMAGE`, etc.
     *
     * If this is unspecified, the operation returns objects of all the top level types at the version
     * of the Square API used to make the request. Object types that are nested onto other object types
     * are not included in the defaults.
     *
     * At the current API version the default object types are:
     * ITEM, CATEGORY, TAX, DISCOUNT, MODIFIER_LIST,
     * PRICING_RULE, PRODUCT_SET, TIME_PERIOD, MEASUREMENT_UNIT,
     * SUBSCRIPTION_PLAN, ITEM_OPTION, CUSTOM_ATTRIBUTE_DEFINITION, QUICK_AMOUNT_SETTINGS.
     */
    public function getTypes(): ?string
    {
        if (count($this->types) == 0) {
            return null;
        }
        return $this->types['value'];
    }

    /**
     * Sets Types.
     * An optional case-insensitive, comma-separated list of object types to retrieve.
     *
     * The valid values are defined in the [CatalogObjectType](entity:CatalogObjectType) enum, for example,
     * `ITEM`, `ITEM_VARIATION`, `CATEGORY`, `DISCOUNT`, `TAX`,
     * `MODIFIER`, `MODIFIER_LIST`, `IMAGE`, etc.
     *
     * If this is unspecified, the operation returns objects of all the top level types at the version
     * of the Square API used to make the request. Object types that are nested onto other object types
     * are not included in the defaults.
     *
     * At the current API version the default object types are:
     * ITEM, CATEGORY, TAX, DISCOUNT, MODIFIER_LIST,
     * PRICING_RULE, PRODUCT_SET, TIME_PERIOD, MEASUREMENT_UNIT,
     * SUBSCRIPTION_PLAN, ITEM_OPTION, CUSTOM_ATTRIBUTE_DEFINITION, QUICK_AMOUNT_SETTINGS.
     *
     * @maps types
     */
    public function setTypes(?string $types): void
    {
        $this->types['value'] = $types;
    }

    /**
     * Unsets Types.
     * An optional case-insensitive, comma-separated list of object types to retrieve.
     *
     * The valid values are defined in the [CatalogObjectType](entity:CatalogObjectType) enum, for example,
     * `ITEM`, `ITEM_VARIATION`, `CATEGORY`, `DISCOUNT`, `TAX`,
     * `MODIFIER`, `MODIFIER_LIST`, `IMAGE`, etc.
     *
     * If this is unspecified, the operation returns objects of all the top level types at the version
     * of the Square API used to make the request. Object types that are nested onto other object types
     * are not included in the defaults.
     *
     * At the current API version the default object types are:
     * ITEM, CATEGORY, TAX, DISCOUNT, MODIFIER_LIST,
     * PRICING_RULE, PRODUCT_SET, TIME_PERIOD, MEASUREMENT_UNIT,
     * SUBSCRIPTION_PLAN, ITEM_OPTION, CUSTOM_ATTRIBUTE_DEFINITION, QUICK_AMOUNT_SETTINGS.
     */
    public function unsetTypes(): void
    {
        $this->types = [];
    }

    /**
     * Returns Catalog Version.
     * The specific version of the catalog objects to be included in the response.
     * This allows you to retrieve historical versions of objects. The specified version value is matched
     * against
     * the [CatalogObject]($m/CatalogObject)s' `version` attribute.  If not included, results will be from
     * the
     * current version of the catalog.
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
     * The specific version of the catalog objects to be included in the response.
     * This allows you to retrieve historical versions of objects. The specified version value is matched
     * against
     * the [CatalogObject]($m/CatalogObject)s' `version` attribute.  If not included, results will be from
     * the
     * current version of the catalog.
     *
     * @maps catalog_version
     */
    public function setCatalogVersion(?int $catalogVersion): void
    {
        $this->catalogVersion['value'] = $catalogVersion;
    }

    /**
     * Unsets Catalog Version.
     * The specific version of the catalog objects to be included in the response.
     * This allows you to retrieve historical versions of objects. The specified version value is matched
     * against
     * the [CatalogObject]($m/CatalogObject)s' `version` attribute.  If not included, results will be from
     * the
     * current version of the catalog.
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
        if (!empty($this->cursor)) {
            $json['cursor']          = $this->cursor['value'];
        }
        if (!empty($this->types)) {
            $json['types']           = $this->types['value'];
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
