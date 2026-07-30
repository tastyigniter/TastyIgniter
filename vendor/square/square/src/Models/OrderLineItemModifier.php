<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * A [CatalogModifier]($m/CatalogModifier).
 */
class OrderLineItemModifier implements \JsonSerializable
{
    /**
     * @var array
     */
    private $uid = [];

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
     * @var array
     */
    private $quantity = [];

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
    private $metadata = [];

    /**
     * Returns Uid.
     * A unique ID that identifies the modifier only within this order.
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
     * A unique ID that identifies the modifier only within this order.
     *
     * @maps uid
     */
    public function setUid(?string $uid): void
    {
        $this->uid['value'] = $uid;
    }

    /**
     * Unsets Uid.
     * A unique ID that identifies the modifier only within this order.
     */
    public function unsetUid(): void
    {
        $this->uid = [];
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
     * The version of the catalog object that this modifier references.
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
     * The version of the catalog object that this modifier references.
     *
     * @maps catalog_version
     */
    public function setCatalogVersion(?int $catalogVersion): void
    {
        $this->catalogVersion['value'] = $catalogVersion;
    }

    /**
     * Unsets Catalog Version.
     * The version of the catalog object that this modifier references.
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
     * Returns Metadata.
     * Application-defined data attached to this order. Metadata fields are intended
     * to store descriptive references or associations with an entity in another system or store brief
     * information about the object. Square does not process this field; it only stores and returns it
     * in relevant API calls. Do not use metadata to store any sensitive information (such as personally
     * identifiable information or card details).
     *
     * Keys written by applications must be 60 characters or less and must be in the character set
     * `[a-zA-Z0-9_-]`. Entries can also include metadata generated by Square. These keys are prefixed
     * with a namespace, separated from the key with a ':' character.
     *
     * Values have a maximum length of 255 characters.
     *
     * An application can have up to 10 entries per metadata field.
     *
     * Entries written by applications are private and can only be read or modified by the same
     * application.
     *
     * For more information, see  [Metadata](https://developer.squareup.com/docs/build-basics/metadata).
     *
     * @return array<string,string>|null
     */
    public function getMetadata(): ?array
    {
        if (count($this->metadata) == 0) {
            return null;
        }
        return $this->metadata['value'];
    }

    /**
     * Sets Metadata.
     * Application-defined data attached to this order. Metadata fields are intended
     * to store descriptive references or associations with an entity in another system or store brief
     * information about the object. Square does not process this field; it only stores and returns it
     * in relevant API calls. Do not use metadata to store any sensitive information (such as personally
     * identifiable information or card details).
     *
     * Keys written by applications must be 60 characters or less and must be in the character set
     * `[a-zA-Z0-9_-]`. Entries can also include metadata generated by Square. These keys are prefixed
     * with a namespace, separated from the key with a ':' character.
     *
     * Values have a maximum length of 255 characters.
     *
     * An application can have up to 10 entries per metadata field.
     *
     * Entries written by applications are private and can only be read or modified by the same
     * application.
     *
     * For more information, see  [Metadata](https://developer.squareup.com/docs/build-basics/metadata).
     *
     * @maps metadata
     *
     * @param array<string,string>|null $metadata
     */
    public function setMetadata(?array $metadata): void
    {
        $this->metadata['value'] = $metadata;
    }

    /**
     * Unsets Metadata.
     * Application-defined data attached to this order. Metadata fields are intended
     * to store descriptive references or associations with an entity in another system or store brief
     * information about the object. Square does not process this field; it only stores and returns it
     * in relevant API calls. Do not use metadata to store any sensitive information (such as personally
     * identifiable information or card details).
     *
     * Keys written by applications must be 60 characters or less and must be in the character set
     * `[a-zA-Z0-9_-]`. Entries can also include metadata generated by Square. These keys are prefixed
     * with a namespace, separated from the key with a ':' character.
     *
     * Values have a maximum length of 255 characters.
     *
     * An application can have up to 10 entries per metadata field.
     *
     * Entries written by applications are private and can only be read or modified by the same
     * application.
     *
     * For more information, see  [Metadata](https://developer.squareup.com/docs/build-basics/metadata).
     */
    public function unsetMetadata(): void
    {
        $this->metadata = [];
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
            $json['uid']               = $this->uid['value'];
        }
        if (!empty($this->catalogObjectId)) {
            $json['catalog_object_id'] = $this->catalogObjectId['value'];
        }
        if (!empty($this->catalogVersion)) {
            $json['catalog_version']   = $this->catalogVersion['value'];
        }
        if (!empty($this->name)) {
            $json['name']              = $this->name['value'];
        }
        if (!empty($this->quantity)) {
            $json['quantity']          = $this->quantity['value'];
        }
        if (isset($this->basePriceMoney)) {
            $json['base_price_money']  = $this->basePriceMoney;
        }
        if (isset($this->totalPriceMoney)) {
            $json['total_price_money'] = $this->totalPriceMoney;
        }
        if (!empty($this->metadata)) {
            $json['metadata']          = $this->metadata['value'];
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
