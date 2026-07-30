<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Represents an applied portion of a discount to a line item in an order.
 *
 * Order scoped discounts have automatically applied discounts present for each line item.
 * Line-item scoped discounts must have applied discounts added manually for any applicable line
 * items. The corresponding applied money is automatically computed based on participating
 * line items.
 */
class OrderLineItemAppliedDiscount implements \JsonSerializable
{
    /**
     * @var array
     */
    private $uid = [];

    /**
     * @var string
     */
    private $discountUid;

    /**
     * @var Money|null
     */
    private $appliedMoney;

    /**
     * @param string $discountUid
     */
    public function __construct(string $discountUid)
    {
        $this->discountUid = $discountUid;
    }

    /**
     * Returns Uid.
     * A unique ID that identifies the applied discount only within this order.
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
     * A unique ID that identifies the applied discount only within this order.
     *
     * @maps uid
     */
    public function setUid(?string $uid): void
    {
        $this->uid['value'] = $uid;
    }

    /**
     * Unsets Uid.
     * A unique ID that identifies the applied discount only within this order.
     */
    public function unsetUid(): void
    {
        $this->uid = [];
    }

    /**
     * Returns Discount Uid.
     * The `uid` of the discount that the applied discount represents. It must
     * reference a discount present in the `order.discounts` field.
     *
     * This field is immutable. To change which discounts apply to a line item,
     * you must delete the discount and re-add it as a new `OrderLineItemAppliedDiscount`.
     */
    public function getDiscountUid(): string
    {
        return $this->discountUid;
    }

    /**
     * Sets Discount Uid.
     * The `uid` of the discount that the applied discount represents. It must
     * reference a discount present in the `order.discounts` field.
     *
     * This field is immutable. To change which discounts apply to a line item,
     * you must delete the discount and re-add it as a new `OrderLineItemAppliedDiscount`.
     *
     * @required
     * @maps discount_uid
     */
    public function setDiscountUid(string $discountUid): void
    {
        $this->discountUid = $discountUid;
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
        $json['discount_uid']      = $this->discountUid;
        if (isset($this->appliedMoney)) {
            $json['applied_money'] = $this->appliedMoney;
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
