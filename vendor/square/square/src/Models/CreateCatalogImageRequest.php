<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

class CreateCatalogImageRequest implements \JsonSerializable
{
    /**
     * @var string
     */
    private $idempotencyKey;

    /**
     * @var string|null
     */
    private $objectId;

    /**
     * @var CatalogObject
     */
    private $image;

    /**
     * @var bool|null
     */
    private $isPrimary;

    /**
     * @param string $idempotencyKey
     * @param CatalogObject $image
     */
    public function __construct(string $idempotencyKey, CatalogObject $image)
    {
        $this->idempotencyKey = $idempotencyKey;
        $this->image = $image;
    }

    /**
     * Returns Idempotency Key.
     * A unique string that identifies this CreateCatalogImage request.
     * Keys can be any valid string but must be unique for every CreateCatalogImage request.
     *
     * See [Idempotency keys](https://developer.squareup.com/docs/build-basics/common-api-
     * patterns/idempotency) for more information.
     */
    public function getIdempotencyKey(): string
    {
        return $this->idempotencyKey;
    }

    /**
     * Sets Idempotency Key.
     * A unique string that identifies this CreateCatalogImage request.
     * Keys can be any valid string but must be unique for every CreateCatalogImage request.
     *
     * See [Idempotency keys](https://developer.squareup.com/docs/build-basics/common-api-
     * patterns/idempotency) for more information.
     *
     * @required
     * @maps idempotency_key
     */
    public function setIdempotencyKey(string $idempotencyKey): void
    {
        $this->idempotencyKey = $idempotencyKey;
    }

    /**
     * Returns Object Id.
     * Unique ID of the `CatalogObject` to attach this `CatalogImage` object to. Leave this
     * field empty to create unattached images, for example if you are building an integration
     * where an image can be attached to catalog items at a later time.
     */
    public function getObjectId(): ?string
    {
        return $this->objectId;
    }

    /**
     * Sets Object Id.
     * Unique ID of the `CatalogObject` to attach this `CatalogImage` object to. Leave this
     * field empty to create unattached images, for example if you are building an integration
     * where an image can be attached to catalog items at a later time.
     *
     * @maps object_id
     */
    public function setObjectId(?string $objectId): void
    {
        $this->objectId = $objectId;
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
    public function getImage(): CatalogObject
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
     * @required
     * @maps image
     */
    public function setImage(CatalogObject $image): void
    {
        $this->image = $image;
    }

    /**
     * Returns Is Primary.
     * If this is set to `true`, the image created will be the primary, or first image of the object
     * referenced by `object_id`.
     * If the `CatalogObject` already has a primary `CatalogImage`, setting this field to `true` will
     * replace the primary image.
     * If this is set to `false` and you use the Square API version 2021-12-15 or later, the image id will
     * be appended to the list of `image_ids` on the object.
     *
     * With Square API version 2021-12-15 or later, the default value is `false`. Otherwise, the effective
     * default value is `true`.
     */
    public function getIsPrimary(): ?bool
    {
        return $this->isPrimary;
    }

    /**
     * Sets Is Primary.
     * If this is set to `true`, the image created will be the primary, or first image of the object
     * referenced by `object_id`.
     * If the `CatalogObject` already has a primary `CatalogImage`, setting this field to `true` will
     * replace the primary image.
     * If this is set to `false` and you use the Square API version 2021-12-15 or later, the image id will
     * be appended to the list of `image_ids` on the object.
     *
     * With Square API version 2021-12-15 or later, the default value is `false`. Otherwise, the effective
     * default value is `true`.
     *
     * @maps is_primary
     */
    public function setIsPrimary(?bool $isPrimary): void
    {
        $this->isPrimary = $isPrimary;
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
        if (isset($this->objectId)) {
            $json['object_id']   = $this->objectId;
        }
        $json['image']           = $this->image;
        if (isset($this->isPrimary)) {
            $json['is_primary']  = $this->isPrimary;
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
