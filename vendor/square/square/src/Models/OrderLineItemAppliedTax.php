<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Represents an applied portion of a tax to a line item in an order.
 *
 * Order-scoped taxes automatically include the applied taxes in each line item.
 * Line item taxes must be referenced from any applicable line items.
 * The corresponding applied money is automatically computed, based on the
 * set of participating line items.
 */
class OrderLineItemAppliedTax implements \JsonSerializable
{
    /**
     * @var array
     */
    private $uid = [];

    /**
     * @var string
     */
    private $taxUid;

    /**
     * @var Money|null
     */
    private $appliedMoney;

    /**
     * @param string $taxUid
     */
    public function __construct(string $taxUid)
    {
        $this->taxUid = $taxUid;
    }

    /**
     * Returns Uid.
     * A unique ID that identifies the applied tax only within this order.
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
     * A unique ID that identifies the applied tax only within this order.
     *
     * @maps uid
     */
    public function setUid(?string $uid): void
    {
        $this->uid['value'] = $uid;
    }

    /**
     * Unsets Uid.
     * A unique ID that identifies the applied tax only within this order.
     */
    public function unsetUid(): void
    {
        $this->uid = [];
    }

    /**
     * Returns Tax Uid.
     * The `uid` of the tax for which this applied tax represents. It must reference
     * a tax present in the `order.taxes` field.
     *
     * This field is immutable. To change which taxes apply to a line item, delete and add a new
     * `OrderLineItemAppliedTax`.
     */
    public function getTaxUid(): string
    {
        return $this->taxUid;
    }

    /**
     * Sets Tax Uid.
     * The `uid` of the tax for which this applied tax represents. It must reference
     * a tax present in the `order.taxes` field.
     *
     * This field is immutable. To change which taxes apply to a line item, delete and add a new
     * `OrderLineItemAppliedTax`.
     *
     * @required
     * @maps tax_uid
     */
    public function setTaxUid(string $taxUid): void
    {
        $this->taxUid = $taxUid;
    }

    /**
     * Returns Applied Money.
     * Represents an amount of money. `Money` fields can be signed or unsigned.
     * Fields that do not explicitly define whether they are signed or unsigned are
     * considered unsigned and can only hold positive amounts. For signed fields, the
     * sign of the value indicates the purpose of the money transfer. See
     * [Working with Monetary Amounts](https://developer.squareup.com/docs/build-basics/working-with-
     * monetary-amounts)
     * for more information.
     */
    public function getAppliedMoney(): ?Money
    {
        return $this->appliedMoney;
    }

    /**
     * Sets Applied Money.
     * Represents an amount of money. `Money` fields can be signed or unsigned.
     * Fields that do not explicitly define whether they are signed or unsigned are
     * considered unsigned and can only hold positive amounts. For signed fields, the
     * sign of the value indicates the purpose of the money transfer. See
     * [Working with Monetary Amounts](https://developer.squareup.com/docs/build-basics/working-with-
     * monetary-amounts)
     * for more information.
     *
     * @maps applied_money
     */
    public function setAppliedMoney(?Money $appliedMoney): void
    {
        $this->appliedMoney = $appliedMoney;
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
            $json['uid']           = $this->uid['value'];
        }
        $json['tax_uid']           = $this->taxUid;
        if (isset($this->appliedMoney)) {
            $json['applied_money'] = $this->appliedMoney;
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
