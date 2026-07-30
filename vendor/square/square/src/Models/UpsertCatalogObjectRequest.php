<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

class UpsertCatalogObjectRequest implements \JsonSerializable
{
    /**
     * @var string
     */
    private $idempotencyKey;

    /**
     * @var CatalogObject
     */
    private $object;

    /**
     * @param string $idempotencyKey
     * @param CatalogObject $object
     */
    public function __construct(string $idempotencyKey, CatalogObject $object)
    {
        $this->idempotencyKey = $idempotencyKey;
        $this->object = $object;
    }

    /**
     * Returns Idempotency Key.
     * A value you specify that uniquely identifies this
     * request among all your requests. A common way to create
     * a valid idempotency key is to use a Universally unique
     * identifier (UUID).
     *
     * If you're unsure whether a particular request was successful,
     * you can reattempt it with the same idempotency key without
     * worrying about creating duplicate objects.
     *
     * See [Idempotency](https://developer.squareup.com/docs/build-basics/common-api-patterns/idempotency)
     * for more information.
     */
    public function getIdempotencyKey(): string
    {
        return $this->idempotencyKey;
    }

    /**
     * Sets Idempotency Key.
     * A value you specify that uniquely identifies this
     * request among all your requests. A common way to create
     * a valid idempotency key is to use a Universally unique
     * identifier (UUID).
     *
     * If you're unsure whether a particular request was successful,
     * you can reattempt it with the same idempotency key without
     * worrying about creating duplicate objects.
     *
     * See [Idempotency](https://developer.squareup.com/docs/build-basics/common-api-patterns/idempotency)
     * for more information.
     *
     * @required
     * @maps idempotency_key
     */
    public function setIdempotencyKey(string $idempotencyKey): void
    {
        $this->idempotencyKey = $idempotencyKey;
    }

    /**
     * Returns Object.
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
    public function getObject(): CatalogObject
    {
        return $this->object;
    }

    /**
     * Sets Object.
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
     * @required
     * @maps object
     */
    public function setObject(CatalogObject $object): void
    {
        $this->object = $object;
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
        $json['idempotency_key'] = $this->idempotencyKey;
        $json['object']          = $this->object;
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
