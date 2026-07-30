<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * V1PaymentTax
 */
class V1PaymentTax implements \JsonSerializable
{
    /**
     * @var array
     */
    private $errors = [];

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
     * @var string|null
     */
    private $inclusionType;

    /**
     * @var array
     */
    private $feeId = [];

    /**
     * Returns Errors.
     * Any errors that occurred during the request.
     *
     * @return Error[]|null
     */
    public function getErrors(): ?array
    {
        if (count($this->errors) == 0) {
            return null;
        }
        return $this->errors['value'];
    }

    /**
     * Sets Errors.
     * Any errors that occurred during the request.
     *
     * @maps errors
     *
     * @param Error[]|null $errors
     */
    public function setErrors(?array $errors): void
    {
        $this->errors['value'] = $errors;
    }

    /**
     * Unsets Errors.
     * Any errors that occurred during the request.
     */
    public function unsetErrors(): void
    {
        $this->errors = [];
    }

    /**
     * Returns Name.
     * The merchant-defined name of the tax.
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
     * The merchant-defined name of the tax.
     *
     * @maps name
     */
    public function setName(?string $name): void
    {
        $this->name['value'] = $name;
    }

    /**
     * Unsets Name.
     * The merchant-defined name of the tax.
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
     * The rate of the tax, as a string representation of a decimal number. A value of 0.07 corresponds to
     * a rate of 7%.
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
     * The rate of the tax, as a string representation of a decimal number. A value of 0.07 corresponds to
     * a rate of 7%.
     *
     * @maps rate
     */
    public function setRate(?string $rate): void
    {
        $this->rate['value'] = $rate;
    }

    /**
     * Unsets Rate.
     * The rate of the tax, as a string representation of a decimal number. A value of 0.07 corresponds to
     * a rate of 7%.
     */
    public function unsetRate(): void
    {
        $this->rate = [];
    }

    /**
     * Returns Inclusion Type.
     */
    public function getInclusionType(): ?string
    {
        return $this->inclusionType;
    }

    /**
     * Sets Inclusion Type.
     *
     * @maps inclusion_type
     */
    public function setInclusionType(?string $inclusionType): void
    {
        $this->inclusionType = $inclusionType;
    }

    /**
     * Returns Fee Id.
     * The ID of the tax, if available. Taxes applied in older versions of Square Register might not have
     * an ID.
     */
    public function getFeeId(): ?string
    {
        if (count($this->feeId) == 0) {
            return null;
        }
        return $this->feeId['value'];
    }

    /**
     * Sets Fee Id.
     * The ID of the tax, if available. Taxes applied in older versions of Square Register might not have
     * an ID.
     *
     * @maps fee_id
     */
    public function setFeeId(?string $feeId): void
    {
        $this->feeId['value'] = $feeId;
    }

    /**
     * Unsets Fee Id.
     * The ID of the tax, if available. Taxes applied in older versions of Square Register might not have
     * an ID.
     */
    public function unsetFeeId(): void
    {
        $this->feeId = [];
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
        if (!empty($this->errors)) {
            $json['errors']         = $this->errors['value'];
        }
        if (!empty($this->name)) {
            $json['name']           = $this->name['value'];
        }
        if (isset($this->appliedMoney)) {
            $json['applied_money']  = $this->appliedMoney;
        }
        if (!empty($this->rate)) {
            $json['rate']           = $this->rate['value'];
        }
        if (isset($this->inclusionType)) {
            $json['inclusion_type'] = $this->inclusionType;
        }
        if (!empty($this->feeId)) {
            $json['fee_id']         = $this->feeId['value'];
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
