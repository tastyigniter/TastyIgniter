<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * A modifier applicable to items at the time of sale.
 */
class CatalogModifier implements \JsonSerializable
{
    /**
     * @var array
     */
    private $name = [];

    /**
     * @var Money|null
     */
    private $priceMoney;

    /**
     * @var array
     */
    private $ordinal = [];

    /**
     * @var array
     */
    private $modifierListId = [];

    /**
     * @var array
     */
    private $imageId = [];

    /**
     * Returns Name.
     * The modifier name.  This is a searchable attribute for use in applicable query filters, and its
     * value length is of Unicode code points.
     */
    public function getName(): ?string
    {
        if (count($this->name) == 0) {
            return null;
        }
        return $this->name['value'];
    }

    /**
     * Sets Name.
     * The modifier name.  This is a searchable attribute for use in applicable query filters, and its
     * value length is of Unicode code points.
     *
     * @maps name
     */
    public function setName(?string $name): void
    {
        $this->name['value'] = $name;
    }

    /**
     * Unsets Name.
     * The modifier name.  This is a searchable attribute for use in applicable query filters, and its
     * value length is of Unicode code points.
     */
    public function unsetName(): void
    {
        $this->name = [];
    }

    /**
     * Returns Price Money.
     * Represents an amount of money. `Money` fields can be signed or unsigned.
     * Fields that do not explicitly define whether they are signed or unsigned are
     * considered unsigned and can only hold positive amounts. For signed fields, the
     * sign of the value indicates the purpose of the money transfer. See
     * [Working with Monetary Amounts](https://developer.squareup.com/docs/build-basics/working-with-
     * monetary-amounts)
     * for more information.
     */
    public function getPriceMoney(): ?Money
    {
        return $this->priceMoney;
    }

    /**
     * Sets Price Money.
     * Represents an amount of money. `Money` fields can be signed or unsigned.
     * Fields that do not explicitly define whether they are signed or unsigned are
     * considered unsigned and can only hold positive amounts. For signed fields, the
     * sign of the value indicates the purpose of the money transfer. See
     * [Working with Monetary Amounts](https://developer.squareup.com/docs/build-basics/working-with-
     * monetary-amounts)
     * for more information.
     *
     * @maps price_money
     */
    public function setPriceMoney(?Money $priceMoney): void
    {
        $this->priceMoney = $priceMoney;
    }

    /**
     * Returns Ordinal.
     * Determines where this `CatalogModifier` appears in the `CatalogModifierList`.
     */
    public function getOrdinal(): ?int
    {
        if (count($this->ordinal) == 0) {
            return null;
        }
        return $this->ordinal['value'];
    }

    /**
     * Sets Ordinal.
     * Determines where this `CatalogModifier` appears in the `CatalogModifierList`.
     *
     * @maps ordinal
     */
    public function setOrdinal(?int $ordinal): void
    {
        $this->ordinal['value'] = $ordinal;
    }

    /**
     * Unsets Ordinal.
     * Determines where this `CatalogModifier` appears in the `CatalogModifierList`.
     */
    public function unsetOrdinal(): void
    {
        $this->ordinal = [];
    }

    /**
     * Returns Modifier List Id.
     * The ID of the `CatalogModifierList` associated with this modifier.
     */
    public function getModifierListId(): ?string
    {
        if (count($this->modifierListId) == 0) {
            return null;
        }
        return $this->modifierListId['value'];
    }

    /**
     * Sets Modifier List Id.
     * The ID of the `CatalogModifierList` associated with this modifier.
     *
     * @maps modifier_list_id
     */
    public function setModifierListId(?string $modifierListId): void
    {
        $this->modifierListId['value'] = $modifierListId;
    }

    /**
     * Unsets Modifier List Id.
     * The ID of the `CatalogModifierList` associated with this modifier.
     */
    public function unsetModifierListId(): void
    {
        $this->modifierListId = [];
    }

    /**
     * Returns Image Id.
     * The ID of the image associated with this `CatalogModifier` instance.
     * Currently this image is not displayed by Square, but is free to be displayed in 3rd party
     * applications.
     */
    public function getImageId(): ?string
    {
        if (count($this->imageId) == 0) {
            return null;
        }
        return $this->imageId['value'];
    }

    /**
     * Sets Image Id.
     * The ID of the image associated with this `CatalogModifier` instance.
     * Currently this image is not displayed by Square, but is free to be displayed in 3rd party
     * applications.
     *
     * @maps image_id
     */
    public function setImageId(?string $imageId): void
    {
        $this->imageId['value'] = $imageId;
    }

    /**
     * Unsets Image Id.
     * The ID of the image associated with this `CatalogModifier` instance.
     * Currently this image is not displayed by Square, but is free to be displayed in 3rd party
     * applications.
     */
    public function unsetImageId(): void
    {
        $this->imageId = [];
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
        if (!empty($this->name)) {
            $json['name']             = $this->name['value'];
        }
        if (isset($this->priceMoney)) {
            $json['price_money']      = $this->priceMoney;
        }
        if (!empty($this->ordinal)) {
            $json['ordinal']          = $this->ordinal['value'];
        }
        if (!empty($this->modifierListId)) {
            $json['modifier_list_id'] = $this->modifierListId['value'];
        }
        if (!empty($this->imageId)) {
            $json['image_id']         = $this->imageId['value'];
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
