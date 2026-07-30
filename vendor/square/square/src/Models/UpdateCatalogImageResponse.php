<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

class UpdateCatalogImageResponse implements \JsonSerializable
{
    /**
     * @var Error[]|null
     */
    private $errors;

    /**
     * @var CatalogObject|null
     */
    private $image;

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
     * Returns Image.
     * The wrapper object for the catalog entries of a given object type.
     *
     * Depending on the `type` attribute value, a `CatalogObject` instance assumes a type-specific data to
     * yield the corresponding type of catalog object.
     *
     * For example, if `type=ITEM`, the `CatalogObject` instance must have the ITEM-specific data set on
     * the `item_data` attribute. The resulting `CatalogObject` instance is also a `CatalogItem` instance.
     *
     * In general, if `type=<OBJECT_TYPE>`, the `CatalogObject` instance must have the `<OBJECT_TYPE>`-
     * specific data set on the `<object_type>_data` attribute. The resulting `CatalogObject` instance is
     * also a `Catalog<ObjectType>` instance.
     *
     * For a more detailed discussion of the Catalog data model, please see the
     * [Design a Catalog](https://developer.squareup.com/docs/catalog-api/design-a-catalog) guide.
     */
    public function getImage(): ?CatalogObject
    {
        return $this->image;
    }

    /**
     * Sets Image.
     * The wrapper object for the catalog entries of a given object type.
     *
     * Depending on the `type` attribute value, a `CatalogObject` instance assumes a type-specific data to
     * yield the corresponding type of catalog object.
     *
     * For example, if `type=ITEM`, the `CatalogObject` instance must have the ITEM-specific data set on
     * the `item_data` attribute. The resulting `CatalogObject` instance is also a `CatalogItem` instance.
     *
     * In general, if `type=<OBJECT_TYPE>`, the `CatalogObject` instance must have the `<OBJECT_TYPE>`-
     * specific data set on the `<object_type>_data` attribute. The resulting `CatalogObject` instance is
     * also a `Catalog<ObjectType>` instance.
     *
     * For a more detailed discussion of the Catalog data model, please see the
     * [Design a Catalog](https://developer.squareup.com/docs/catalog-api/design-a-catalog) guide.
     *
     * @maps image
     */
    public function setImage(?CatalogObject $image): void
    {
        $this->image = $image;
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
            $json['errors'] = $this->errors;
        }
        if (isset($this->image)) {
            $json['image']  = $this->image;
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
