<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * A discount applicable to items.
 */
class CatalogDiscount implements \JsonSerializable
{
    /**
     * @var array
     */
    private $name = [];

    /**
     * @var string|null
     */
    private $discountType;

    /**
     * @var array
     */
    private $percentage = [];

    /**
     * @var Money|null
     */
    private $amountMoney;

    /**
     * @var array
     */
    private $pinRequired = [];

    /**
     * @var array
     */
    private $labelColor = [];

    /**
     * @var string|null
     */
    private $modifyTaxBasis;

    /**
     * @var Money|null
     */
    private $maximumAmountMoney;

    /**
     * Returns Name.
     * The discount name. This is a searchable attribute for use in applicable query filters, and its value
     * length is of Unicode code points.
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
     * The discount name. This is a searchable attribute for use in applicable query filters, and its value
     * length is of Unicode code points.
     *
     * @maps name
     */
    public function setName(?string $name): void
    {
        $this->name['value'] = $name;
    }

    /**
     * Unsets Name.
     * The discount name. This is a searchable attribute for use in applicable query filters, and its value
     * length is of Unicode code points.
     */
    public function unsetName(): void
    {
        $this->name = [];
    }

    /**
     * Returns Discount Type.
     * How to apply a CatalogDiscount to a CatalogItem.
     */
    public function getDiscountType(): ?string
    {
        return $this->discountType;
    }

    /**
     * Sets Discount Type.
     * How to apply a CatalogDiscount to a CatalogItem.
     *
     * @maps discount_type
     */
    public function setDiscountType(?string $discountType): void
    {
        $this->discountType = $discountType;
    }

    /**
     * Returns Percentage.
     * The percentage of the discount as a string representation of a decimal number, using a `.` as the
     * decimal
     * separator and without a `%` sign. A value of `7.5` corresponds to `7.5%`. Specify a percentage of
     * `0` if `discount_type`
     * is `VARIABLE_PERCENTAGE`.
     *
     * Do not use this field for amount-based or variable discounts.
     */
    public function getPercentage(): ?string
    {
        if (count($this->percentage) == 0) {
            return null;
        }
        return $this->percentage['value'];
    }

    /**
     * Sets Percentage.
     * The percentage of the discount as a string representation of a decimal number, using a `.` as the
     * decimal
     * separator and without a `%` sign. A value of `7.5` corresponds to `7.5%`. Specify a percentage of
     * `0` if `discount_type`
     * is `VARIABLE_PERCENTAGE`.
     *
     * Do not use this field for amount-based or variable discounts.
     *
     * @maps percentage
     */
    public function setPercentage(?string $percentage): void
    {
        $this->percentage['value'] = $percentage;
    }

    /**
     * Unsets Percentage.
     * The percentage of the discount as a string representation of a decimal number, using a `.` as the
     * decimal
     * separator and without a `%` sign. A value of `7.5` corresponds to `7.5%`. Specify a percentage of
     * `0` if `discount_type`
     * is `VARIABLE_PERCENTAGE`.
     *
     * Do not use this field for amount-based or variable discounts.
     */
    public function unsetPercentage(): void
    {
        $this->percentage = [];
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
    public function getAmountMoney(): ?Money
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
     * @maps amount_money
     */
    public function setAmountMoney(?Money $amountMoney): void
    {
        $this->amountMoney = $amountMoney;
    }

    /**
     * Returns Pin Required.
     * Indicates whether a mobile staff member needs to enter their PIN to apply the
     * discount to a payment in the Square Point of Sale app.
     */
    public function getPinRequired(): ?bool
    {
        if (count($this->pinRequired) == 0) {
            return null;
        }
        return $this->pinRequired['value'];
    }

    /**
     * Sets Pin Required.
     * Indicates whether a mobile staff member needs to enter their PIN to apply the
     * discount to a payment in the Square Point of Sale app.
     *
     * @maps pin_required
     */
    public function setPinRequired(?bool $pinRequired): void
    {
        $this->pinRequired['value'] = $pinRequired;
    }

    /**
     * Unsets Pin Required.
     * Indicates whether a mobile staff member needs to enter their PIN to apply the
     * discount to a payment in the Square Point of Sale app.
     */
    public function unsetPinRequired(): void
    {
        $this->pinRequired = [];
    }

    /**
     * Returns Label Color.
     * The color of the discount display label in the Square Point of Sale app. This must be a valid hex
     * color code.
     */
    public function getLabelColor(): ?string
    {
        if (count($this->labelColor) == 0) {
            return null;
        }
        return $this->labelColor['value'];
    }

    /**
     * Sets Label Color.
     * The color of the discount display label in the Square Point of Sale app. This must be a valid hex
     * color code.
     *
     * @maps label_color
     */
    public function setLabelColor(?string $labelColor): void
    {
        $this->labelColor['value'] = $labelColor;
    }

    /**
     * Unsets Label Color.
     * The color of the discount display label in the Square Point of Sale app. This must be a valid hex
     * color code.
     */
    public function unsetLabelColor(): void
    {
        $this->labelColor = [];
    }

    /**
     * Returns Modify Tax Basis.
     */
    public function getModifyTaxBasis(): ?string
    {
        return $this->modifyTaxBasis;
    }

    /**
     * Sets Modify Tax Basis.
     *
     * @maps modify_tax_basis
     */
    public function setModifyTaxBasis(?string $modifyTaxBasis): void
    {
        $this->modifyTaxBasis = $modifyTaxBasis;
    }

    /**
     * Returns Maximum Amount Money.
     * Represents an amount of money. `Money` fields can be signed or unsigned.
     * Fields that do not explicitly define whether they are signed or unsigned are
     * considered unsigned and can only hold positive amounts. For signed fields, the
     * sign of the value indicates the purpose of the money transfer. See
     * [Working with Monetary Amounts](https://developer.squareup.com/docs/build-basics/working-with-
     * monetary-amounts)
     * for more information.
     */
    public function getMaximumAmountMoney(): ?Money
    {
        return $this->maximumAmountMoney;
    }

    /**
     * Sets Maximum Amount Money.
     * Represents an amount of money. `Money` fields can be signed or unsigned.
     * Fields that do not explicitly define whether they are signed or unsigned are
     * considered unsigned and can only hold positive amounts. For signed fields, the
     * sign of the value indicates the purpose of the money transfer. See
     * [Working with Monetary Amounts](https://developer.squareup.com/docs/build-basics/working-with-
     * monetary-amounts)
     * for more information.
     *
     * @maps maximum_amount_money
     */
    public function setMaximumAmountMoney(?Money $maximumAmountMoney): void
    {
        $this->maximumAmountMoney = $maximumAmountMoney;
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
            $json['name']                 = $this->name['value'];
        }
        if (isset($this->discountType)) {
            $json['discount_type']        = $this->discountType;
        }
        if (!empty($this->percentage)) {
            $json['percentage']           = $this->percentage['value'];
        }
        if (isset($this->amountMoney)) {
            $json['amount_money']         = $this->amountMoney;
        }
        if (!empty($this->pinRequired)) {
            $json['pin_required']         = $this->pinRequired['value'];
        }
        if (!empty($this->labelColor)) {
            $json['label_color']          = $this->labelColor['value'];
        }
        if (isset($this->modifyTaxBasis)) {
            $json['modify_tax_basis']     = $this->modifyTaxBasis;
        }
        if (isset($this->maximumAmountMoney)) {
            $json['maximum_amount_money'] = $this->maximumAmountMoney;
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
