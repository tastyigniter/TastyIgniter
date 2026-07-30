<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Represents an additional recipient (other than the merchant) entitled to a portion of the tender.
 * Support is currently limited to USD, CAD and GBP currencies
 */
class ChargeRequestAdditionalRecipient implements \JsonSerializable
{
    /**
     * @var string
     */
    private $locationId;

    /**
     * @var string
     */
    private $description;

    /**
     * @var Money
     */
    private $amountMoney;

    /**
     * @param string $locationId
     * @param string $description
     * @param Money $amountMoney
     */
    public function __construct(string $locationId, string $description, Money $amountMoney)
    {
        $this->locationId = $locationId;
        $this->description = $description;
        $this->amountMoney = $amountMoney;
    }

    /**
     * Returns Location Id.
     * The location ID for a recipient (other than the merchant) receiving a portion of the tender.
     */
    public function getLocationId(): string
    {
        return $this->locationId;
    }

    /**
     * Sets Location Id.
     * The location ID for a recipient (other than the merchant) receiving a portion of the tender.
     *
     * @required
     * @maps location_id
     */
    public function setLocationId(string $locationId): void
    {
        $this->locationId = $locationId;
    }

    /**
     * Returns Description.
     * The description of the additional recipient.
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * Sets Description.
     * The description of the additional recipient.
     *
     * @required
     * @maps description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * Returns Amount Money.
     * Represents an amount of money. `Money` fields can be signed or unsigned.
     * Fields that do not explicitly define whether they are signed or unsigned are
     * considered unsigned and can only hold positive amounts. For signed fields, the
     * sign of the value indicates the purpose of the money transfer. See
     * [Working with Monetary Amounts](https://developer.squareup.com/docs/build-basics/working-with-
     * monetary-amounts)
     * for more information.
     */
    public function getAmountMoney(): Money
    {
        return $this->amountMoney;
    }

    /**
     * Sets Amount Money.
     * Represents an amount of money. `Money` fields can be signed or unsigned.
     * Fields that do not explicitly define whether they are signed or unsigned are
     * considered unsigned and can only hold positive amounts. For signed fields, the
     * sign of the value indicates the purpose of the money transfer. See
     * [Working with Monetary Amounts](https://developer.squareup.com/docs/build-basics/working-with-
     * monetary-amounts)
     * for more information.
     *
     * @required
     * @maps amount_money
     */
    public function setAmountMoney(Money $amountMoney): void
    {
        $this->amountMoney = $amountMoney;
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
        $json['location_id']  = $this->locationId;
        $json['description']  = $this->description;
        $json['amount_money'] = $this->amountMoney;
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
