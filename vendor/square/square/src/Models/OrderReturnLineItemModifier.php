<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * A line item modifier being returned.
 */
class OrderReturnLineItemModifier implements \JsonSerializable
{
    /**
     * @var array
     */
    private $uid = [];

    /**
     * @var array
     */
    private $sourceModifierUid = [];

    /**
     * @var array
     */
    private $catalogObjectId = [];

    /**
     * @var array
     */
    private $catalogVersion = [];

    /**
     * @var array
     */
    private $name = [];

    /**
     * @var Money|null
     */
    private $basePriceMoney;

    /**
     * @var Money|null
     */
    private $totalPriceMoney;

    /**
     * @var array
     */
    private $quantity = [];

    /**
     * Returns Uid.
     * A unique ID that identifies the return modifier only within this order.
     */
    public function getUid(): ?string
    {
        if (count($this->uid) == 0) {
            return null;
        }
        return $this->uid['value'];
    }

    /**
     * Sets Uid.
     * A unique ID that identifies the return modifier only within this order.
     *
     * @maps uid
     */
    public function setUid(?string $uid): void
    {
        $this->uid['value'] = $uid;
    }

    /**
     * Unsets Uid.
     * A unique ID that identifies the return modifier only within this order.
     */
    public function unsetUid(): void
    {
        $this->uid = [];
    }

    /**
     * Returns Source Modifier Uid.
     * The modifier `uid` from the order's line item that contains the
     * original sale of this line item modifier.
     */
    public function getSourceModifierUid(): ?string
    {
        if (count($this->sourceModifierUid) == 0) {
            return null;
        }
        return $this->sourceModifierUid['value'];
    }

    /**
     * Sets Source Modifier Uid.
     * The modifier `uid` from the order's line item that contains the
     * original sale of this line item modifier.
     *
     * @maps source_modifier_uid
     */
    public function setSourceModifierUid(?string $sourceModifierUid): void
    {
        $this->sourceModifierUid['value'] = $sourceModifierUid;
    }

    /**
     * Unsets Source Modifier Uid.
     * The modifier `uid` from the order's line item that contains the
     * original sale of this line item modifier.
     */
    public function unsetSourceModifierUid(): void
    {
        $this->sourceModifierUid = [];
    }

    /**
     * Returns Catalog Object Id.
     * The catalog object ID referencing [CatalogModifier](entity:CatalogModifier).
     */
    public function getCatalogObjectId(): ?string
    {
        if (count($this->catalogObjectId) == 0) {
            return null;
        }
        return $this->catalogObjectId['value'];
    }

    /**
     * Sets Catalog Object Id.
     * The catalog object ID referencing [CatalogModifier](entity:CatalogModifier).
     *
     * @maps catalog_object_id
     */
    public function setCatalogObjectId(?string $catalogObjectId): void
    {
        $this->catalogObjectId['value'] = $catalogObjectId;
    }

    /**
     * Unsets Catalog Object Id.
     * The catalog object ID referencing [CatalogModifier](entity:CatalogModifier).
     */
    public function unsetCatalogObjectId(): void
    {
        $this->catalogObjectId = [];
    }

    /**
     * Returns Catalog Version.
     * The version of the catalog object that this line item modifier references.
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
     * The version of the catalog object that this line item modifier references.
     *
     * @maps catalog_version
     */
    public function setCatalogVersion(?int $catalogVersion): void
    {
        $this->catalogVersion['value'] = $catalogVersion;
    }

    /**
     * Unsets Catalog Version.
     * The version of the catalog object that this line item modifier references.
     */
    public function unsetCatalogVersion(): void
    {
        $this->catalogVersion = [];
    }

    /**
     * Returns Name.
     * The name of the item modifier.
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
     * The name of the item modifier.
     *
     * @maps name
     */
    public function setName(?string $name): void
    {
        $this->name['value'] = $name;
    }

    /**
     * Unsets Name.
     * The name of the item modifier.
     */
    public function unsetName(): void
    {
        $this->name = [];
    }

    /**
     * Returns Base Price Money.
     * Represents an amount of money. `Money` fields can be signed or unsigned.
     * Fields that do not explicitly define whether they are signed or unsigned are
     * considered unsigned and can only hold positive amounts. For signed fields, the
     * sign of the value indicates the purpose of the money transfer. See
     * [Working with Monetary Amounts](https://developer.squareup.com/docs/build-basics/working-with-
     * monetary-amounts)
     * for more information.
     */
    public function getBasePriceMoney(): ?Money
    {
        return $this->basePriceMoney;
    }

    /**
     * Sets Base Price Money.
     * Represents an amount of money. `Money` fields can be signed or unsigned.
     * Fields that do not explicitly define whether they are signed or unsigned are
     * considered unsigned and can only hold positive amounts. For signed fields, the
     * sign of the value indicates the purpose of the money transfer. See
     * [Working with Monetary Amounts](https://developer.squareup.com/docs/build-basics/working-with-
     * monetary-amounts)
     * for more information.
     *
     * @maps base_price_money
     */
    public function setBasePriceMoney(?Money $basePriceMoney): void
    {
        $this->basePriceMoney = $basePriceMoney;
    }

    /**
     * Returns Total Price Money.
     * Represents an amount of money. `Money` fields can be signed or unsigned.
     * Fields that do not explicitly define whether they are signed or unsigned are
     * considered unsigned and can only hold positive amounts. For signed fields, the
     * sign of the value indicates the purpose of the money transfer. See
     * [Working with Monetary Amounts](https://developer.squareup.com/docs/build-basics/working-with-
     * monetary-amounts)
     * for more information.
     */
    public function getTotalPriceMoney(): ?Money
    {
        return $this->totalPriceMoney;
    }

    /**
     * Sets Total Price Money.
     * Represents an amount of money. `Money` fields can be signed or unsigned.
     * Fields that do not explicitly define whether they are signed or unsigned are
     * considered unsigned and can only hold positive amounts. For signed fields, the
     * sign of the value indicates the purpose of the money transfer. See
     * [Working with Monetary Amounts](https://developer.squareup.com/docs/build-basics/working-with-
     * monetary-amounts)
     * for more information.
     *
     * @maps total_price_money
     */
    public function setTotalPriceMoney(?Money $totalPriceMoney): void
    {
        $this->totalPriceMoney = $totalPriceMoney;
    }

    /**
     * Returns Quantity.
     * The quantity of the line item modifier. The modifier quantity can be 0 or more.
     * For example, suppose a restaurant offers a cheeseburger on the menu. When a buyer orders
     * this item, the restaurant records the purchase by creating an `Order` object with a line item
     * for a burger. The line item includes a line item modifier: the name is cheese and the quantity
     * is 1. The buyer has the option to order extra cheese (or no cheese). If the buyer chooses
     * the extra cheese option, the modifier quantity increases to 2. If the buyer does not want
     * any cheese, the modifier quantity is set to 0.
     */
    public function getQuantity(): ?string
    {
        if (count($this->quantity) == 0) {
            return null;
        }
        return $this->quantity['value'];
    }

    /**
     * Sets Quantity.
     * The quantity of the line item modifier. The modifier quantity can be 0 or more.
     * For example, suppose a restaurant offers a cheeseburger on the menu. When a buyer orders
     * this item, the restaurant records the purchase by creating an `Order` object with a line item
     * for a burger. The line item includes a line item modifier: the name is cheese and the quantity
     * is 1. The buyer has the option to order extra cheese (or no cheese). If the buyer chooses
     * the extra cheese option, the modifier quantity increases to 2. If the buyer does not want
     * any cheese, the modifier quantity is set to 0.
     *
     * @maps quantity
     */
    public function setQuantity(?string $quantity): void
    {
        $this->quantity['value'] = $quantity;
    }

    /**
     * Unsets Quantity.
     * The quantity of the line item modifier. The modifier quantity can be 0 or more.
     * For example, suppose a restaurant offers a cheeseburger on the menu. When a buyer orders
     * this item, the restaurant records the purchase by creating an `Order` object with a line item
     * for a burger. The line item includes a line item modifier: the name is cheese and the quantity
     * is 1. The buyer has the option to order extra cheese (or no cheese). If the buyer chooses
     * the extra cheese option, the modifier quantity increases to 2. If the buyer does not want
     * any cheese, the modifier quantity is set to 0.
     */
    public function unsetQuantity(): void
    {
        $this->quantity = [];
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
        if (!empty($this->uid)) {
            $json['uid']                 = $this->uid['value'];
        }
        if (!empty($this->sourceModifierUid)) {
            $json['source_modifier_uid'] = $this->sourceModifierUid['value'];
        }
        if (!empty($this->catalogObjectId)) {
            $json['catalog_object_id']   = $this->catalogObjectId['value'];
        }
        if (!empty($this->catalogVersion)) {
            $json['catalog_version']     = $this->catalogVersion['value'];
        }
        if (!empty($this->name)) {
            $json['name']                = $this->name['value'];
        }
        if (isset($this->basePriceMoney)) {
            $json['base_price_money']    = $this->basePriceMoney;
        }
        if (isset($this->totalPriceMoney)) {
            $json['total_price_money']   = $this->totalPriceMoney;
        }
        if (!empty($this->quantity)) {
            $json['quantity']            = $this->quantity['value'];
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
