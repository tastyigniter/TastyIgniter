<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * V1PaymentDiscount
 */
class V1PaymentDiscount implements \JsonSerializable
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
    private $discountId = [];

    /**
     * Returns Name.
     * The discount's name.
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
     * The discount's name.
     *
     * @maps name
     */
    public function setName(?string $name): void
    {
        $this->name['value'] = $name;
    }

    /**
     * Unsets Name.
     * The discount's name.
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
     * Returns Discount Id.
     * The ID of the applied discount, if available. Discounts applied in older versions of Square Register
     * might not have an ID.
     */
    public function getDiscountId(): ?string
    {
        if (count($this->discountId) == 0) {
            return null;
        }
        return $this->discountId['value'];
    }

    /**
     * Sets Discount Id.
     * The ID of the applied discount, if available. Discounts applied in older versions of Square Register
     * might not have an ID.
     *
     * @maps discount_id
     */
    public function setDiscountId(?string $discountId): void
    {
        $this->discountId['value'] = $discountId;
    }

    /**
     * Unsets Discount Id.
     * The ID of the applied discount, if available. Discounts applied in older versions of Square Register
     * might not have an ID.
     */
    public function unsetDiscountId(): void
    {
        $this->discountId = [];
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
        if (!empty($this->discountId)) {
            $json['discount_id']   = $this->discountId['value'];
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
