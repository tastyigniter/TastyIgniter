<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Represents additional data for rules with the `VISIT` accrual type.
 */
class LoyaltyProgramAccrualRuleVisitData implements \JsonSerializable
{
    /**
     * @var Money|null
     */
    private $minimumAmountMoney;

    /**
     * @var string
     */
    private $taxMode;

    /**
     * @param string $taxMode
     */
    public function __construct(string $taxMode)
    {
        $this->taxMode = $taxMode;
    }

    /**
     * Returns Minimum Amount Money.
     * Represents an amount of money. `Money` fields can be signed or unsigned.
     * Fields that do not explicitly define whether they are signed or unsigned are
     * considered unsigned and can only hold positive amounts. For signed fields, the
     * sign of the value indicates the purpose of the money transfer. See
     * [Working with Monetary Amounts](https://developer.squareup.com/docs/build-basics/working-with-
     * monetary-amounts)
     * for more information.
     */
    public function getMinimumAmountMoney(): ?Money
    {
        return $this->minimumAmountMoney;
    }

    /**
     * Sets Minimum Amount Money.
     * Represents an amount of money. `Money` fields can be signed or unsigned.
     * Fields that do not explicitly define whether they are signed or unsigned are
     * considered unsigned and can only hold positive amounts. For signed fields, the
     * sign of the value indicates the purpose of the money transfer. See
     * [Working with Monetary Amounts](https://developer.squareup.com/docs/build-basics/working-with-
     * monetary-amounts)
     * for more information.
     *
     * @maps minimum_amount_money
     */
    public function setMinimumAmountMoney(?Money $minimumAmountMoney): void
    {
        $this->minimumAmountMoney = $minimumAmountMoney;
    }

    /**
     * Returns Tax Mode.
     * Indicates how taxes should be treated when calculating the purchase amount used for loyalty points
     * accrual.
     * This setting applies only to `SPEND` accrual rules or `VISIT` accrual rules that have a minimum
     * spend requirement.
     */
    public function getTaxMode(): string
    {
        return $this->taxMode;
    }

    /**
     * Sets Tax Mode.
     * Indicates how taxes should be treated when calculating the purchase amount used for loyalty points
     * accrual.
     * This setting applies only to `SPEND` accrual rules or `VISIT` accrual rules that have a minimum
     * spend requirement.
     *
     * @required
     * @maps tax_mode
     */
    public function setTaxMode(string $taxMode): void
    {
        $this->taxMode = $taxMode;
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
        if (isset($this->minimumAmountMoney)) {
            $json['minimum_amount_money'] = $this->minimumAmountMoney;
        }
        $json['tax_mode']                 = $this->taxMode;
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
