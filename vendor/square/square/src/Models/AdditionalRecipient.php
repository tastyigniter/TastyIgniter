<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Represents an additional recipient (other than the merchant) receiving a portion of this tender.
 */
class AdditionalRecipient implements \JsonSerializable
{
    /**
     * @var string
     */
    private $locationId;

    /**
     * @var array
     */
    private $description = [];

    /**
     * @var Money
     */
    private $amountMoney;

    /**
     * @var array
     */
    private $receivableId = [];

    /**
     * @param string $locationId
     * @param Money $amountMoney
     */
    public function __construct(string $locationId, Money $amountMoney)
    {
        $this->locationId = $locationId;
        $this->amountMoney = $amountMoney;
    }

    /**
     * Returns Location Id.
     * The location ID for a recipient (other than the merchant) receiving a portion of this tender.
     */
    public function getLocationId(): string
    {
        return $this->locationId;
    }

    /**
     * Sets Location Id.
     * The location ID for a recipient (other than the merchant) receiving a portion of this tender.
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
    public function getDescription(): ?string
    {
        if (count($this->description) == 0) {
            return null;
        }
        return $this->description['value'];
    }

    /**
     * Sets Description.
     * The description of the additional recipient.
     *
     * @maps description
     */
    public function setDescription(?string $description): void
    {
        $this->description['value'] = $description;
    }

    /**
     * Unsets Description.
     * The description of the additional recipient.
     */
    public function unsetDescription(): void
    {
        $this->description = [];
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
     * Returns Receivable Id.
     * The unique ID for the RETIRED `AdditionalRecipientReceivable` object. This field should be empty for
     * any `AdditionalRecipient` objects created after the retirement.
     */
    public function getReceivableId(): ?string
    {
        if (count($this->receivableId) == 0) {
            return null;
        }
        return $this->receivableId['value'];
    }

    /**
     * Sets Receivable Id.
     * The unique ID for the RETIRED `AdditionalRecipientReceivable` object. This field should be empty for
     * any `AdditionalRecipient` objects created after the retirement.
     *
     * @maps receivable_id
     */
    public function setReceivableId(?string $receivableId): void
    {
        $this->receivableId['value'] = $receivableId;
    }

    /**
     * Unsets Receivable Id.
     * The unique ID for the RETIRED `AdditionalRecipientReceivable` object. This field should be empty for
     * any `AdditionalRecipient` objects created after the retirement.
     */
    public function unsetReceivableId(): void
    {
        $this->receivableId = [];
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
        $json['location_id']       = $this->locationId;
        if (!empty($this->description)) {
            $json['description']   = $this->description['value'];
        }
        $json['amount_money']      = $this->amountMoney;
        if (!empty($this->receivableId)) {
            $json['receivable_id'] = $this->receivableId['value'];
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
