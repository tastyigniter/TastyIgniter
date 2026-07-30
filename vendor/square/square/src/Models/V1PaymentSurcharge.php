<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * V1PaymentSurcharge
 */
class V1PaymentSurcharge implements \JsonSerializable
{
    /**
     * @var array
     */
    private $name = [];

    /**
     * @var V1Money|null
     */
    private $appliedMoney;

    /**
     * @var array
     */
    private $rate = [];

    /**
     * @var V1Money|null
     */
    private $amountMoney;

    /**
     * @var string|null
     */
    private $type;

    /**
     * @var array
     */
    private $taxable = [];

    /**
     * @var array
     */
    private $taxes = [];

    /**
     * @var array
     */
    private $surchargeId = [];

    /**
     * Returns Name.
     * The name of the surcharge.
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
     * The name of the surcharge.
     *
     * @maps name
     */
    public function setName(?string $name): void
    {
        $this->name['value'] = $name;
    }

    /**
     * Unsets Name.
     * The name of the surcharge.
     */
    public function unsetName(): void
    {
        $this->name = [];
    }

    /**
     * Returns Applied Money.
     */
    public function getAppliedMoney(): ?V1Money
    {
        return $this->appliedMoney;
    }

    /**
     * Sets Applied Money.
     *
     * @maps applied_money
     */
    public function setAppliedMoney(?V1Money $appliedMoney): void
    {
        $this->appliedMoney = $appliedMoney;
    }

    /**
     * Returns Rate.
     * The amount of the surcharge as a percentage. The percentage is provided as a string representing the
     * decimal equivalent of the percentage. For example, "0.7" corresponds to a 7% surcharge. Exactly one
     * of rate or amount_money should be set.
     */
    public function getRate(): ?string
    {
        if (count($this->rate) == 0) {
            return null;
        }
        return $this->rate['value'];
    }

    /**
     * Sets Rate.
     * The amount of the surcharge as a percentage. The percentage is provided as a string representing the
     * decimal equivalent of the percentage. For example, "0.7" corresponds to a 7% surcharge. Exactly one
     * of rate or amount_money should be set.
     *
     * @maps rate
     */
    public function setRate(?string $rate): void
    {
        $this->rate['value'] = $rate;
    }

    /**
     * Unsets Rate.
     * The amount of the surcharge as a percentage. The percentage is provided as a string representing the
     * decimal equivalent of the percentage. For example, "0.7" corresponds to a 7% surcharge. Exactly one
     * of rate or amount_money should be set.
     */
    public function unsetRate(): void
    {
        $this->rate = [];
    }

    /**
     * Returns Amount Money.
     */
    public function getAmountMoney(): ?V1Money
    {
        return $this->amountMoney;
    }

    /**
     * Sets Amount Money.
     *
     * @maps amount_money
     */
    public function setAmountMoney(?V1Money $amountMoney): void
    {
        $this->amountMoney = $amountMoney;
    }

    /**
     * Returns Type.
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * Sets Type.
     *
     * @maps type
     */
    public function setType(?string $type): void
    {
        $this->type = $type;
    }

    /**
     * Returns Taxable.
     * Indicates whether the surcharge is taxable.
     */
    public function getTaxable(): ?bool
    {
        if (count($this->taxable) == 0) {
            return null;
        }
        return $this->taxable['value'];
    }

    /**
     * Sets Taxable.
     * Indicates whether the surcharge is taxable.
     *
     * @maps taxable
     */
    public function setTaxable(?bool $taxable): void
    {
        $this->taxable['value'] = $taxable;
    }

    /**
     * Unsets Taxable.
     * Indicates whether the surcharge is taxable.
     */
    public function unsetTaxable(): void
    {
        $this->taxable = [];
    }

    /**
     * Returns Taxes.
     * The list of taxes that should be applied to the surcharge.
     *
     * @return V1PaymentTax[]|null
     */
    public function getTaxes(): ?array
    {
        if (count($this->taxes) == 0) {
            return null;
        }
        return $this->taxes['value'];
    }

    /**
     * Sets Taxes.
     * The list of taxes that should be applied to the surcharge.
     *
     * @maps taxes
     *
     * @param V1PaymentTax[]|null $taxes
     */
    public function setTaxes(?array $taxes): void
    {
        $this->taxes['value'] = $taxes;
    }

    /**
     * Unsets Taxes.
     * The list of taxes that should be applied to the surcharge.
     */
    public function unsetTaxes(): void
    {
        $this->taxes = [];
    }

    /**
     * Returns Surcharge Id.
     * A Square-issued unique identifier associated with the surcharge.
     */
    public function getSurchargeId(): ?string
    {
        if (count($this->surchargeId) == 0) {
            return null;
        }
        return $this->surchargeId['value'];
    }

    /**
     * Sets Surcharge Id.
     * A Square-issued unique identifier associated with the surcharge.
     *
     * @maps surcharge_id
     */
    public function setSurchargeId(?string $surchargeId): void
    {
        $this->surchargeId['value'] = $surchargeId;
    }

    /**
     * Unsets Surcharge Id.
     * A Square-issued unique identifier associated with the surcharge.
     */
    public function unsetSurchargeId(): void
    {
        $this->surchargeId = [];
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
            $json['name']          = $this->name['value'];
        }
        if (isset($this->appliedMoney)) {
            $json['applied_money'] = $this->appliedMoney;
        }
        if (!empty($this->rate)) {
            $json['rate']          = $this->rate['value'];
        }
        if (isset($this->amountMoney)) {
            $json['amount_money']  = $this->amountMoney;
        }
        if (isset($this->type)) {
            $json['type']          = $this->type;
        }
        if (!empty($this->taxable)) {
            $json['taxable']       = $this->taxable['value'];
        }
        if (!empty($this->taxes)) {
            $json['taxes']         = $this->taxes['value'];
        }
        if (!empty($this->surchargeId)) {
            $json['surcharge_id']  = $this->surchargeId['value'];
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
