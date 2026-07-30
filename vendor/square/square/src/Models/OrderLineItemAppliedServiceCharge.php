<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

class OrderLineItemAppliedServiceCharge implements \JsonSerializable
{
    /**
     * @var array
     */
    private $uid = [];

    /**
     * @var string
     */
    private $serviceChargeUid;

    /**
     * @var Money|null
     */
    private $appliedMoney;

    /**
     * @param string $serviceChargeUid
     */
    public function __construct(string $serviceChargeUid)
    {
        $this->serviceChargeUid = $serviceChargeUid;
    }

    /**
     * Returns Uid.
     * A unique ID that identifies the applied service charge only within this order.
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
     * A unique ID that identifies the applied service charge only within this order.
     *
     * @maps uid
     */
    public function setUid(?string $uid): void
    {
        $this->uid['value'] = $uid;
    }

    /**
     * Unsets Uid.
     * A unique ID that identifies the applied service charge only within this order.
     */
    public function unsetUid(): void
    {
        $this->uid = [];
    }

    /**
     * Returns Service Charge Uid.
     * The `uid` of the service charge that the applied service charge represents. It must
     * reference a service charge present in the `order.service_charges` field.
     *
     * This field is immutable. To change which service charges apply to a line item,
     * delete and add a new `OrderLineItemAppliedServiceCharge`.
     */
    public function getServiceChargeUid(): string
    {
        return $this->serviceChargeUid;
    }

    /**
     * Sets Service Charge Uid.
     * The `uid` of the service charge that the applied service charge represents. It must
     * reference a service charge present in the `order.service_charges` field.
     *
     * This field is immutable. To change which service charges apply to a line item,
     * delete and add a new `OrderLineItemAppliedServiceCharge`.
     *
     * @required
     * @maps service_charge_uid
     */
    public function setServiceChargeUid(string $serviceChargeUid): void
    {
        $this->serviceChargeUid = $serviceChargeUid;
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
            $json['uid']            = $this->uid['value'];
        }
        $json['service_charge_uid'] = $this->serviceChargeUid;
        if (isset($this->appliedMoney)) {
            $json['applied_money']  = $this->appliedMoney;
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
