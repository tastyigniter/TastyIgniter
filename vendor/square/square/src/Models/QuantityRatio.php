<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * A whole number or unreduced fractional ratio.
 */
class QuantityRatio implements \JsonSerializable
{
    /**
     * @var array
     */
    private $quantity = [];

    /**
     * @var array
     */
    private $quantityDenominator = [];

    /**
     * Returns Quantity.
     * The whole or fractional quantity as the numerator.
     */
    public function getQuantity(): ?int
    {
        if (count($this->quantity) == 0) {
            return null;
        }
        return $this->quantity['value'];
    }

    /**
     * Sets Quantity.
     * The whole or fractional quantity as the numerator.
     *
     * @maps quantity
     */
    public function setQuantity(?int $quantity): void
    {
        $this->quantity['value'] = $quantity;
    }

    /**
     * Unsets Quantity.
     * The whole or fractional quantity as the numerator.
     */
    public function unsetQuantity(): void
    {
        $this->quantity = [];
    }

    /**
     * Returns Quantity Denominator.
     * The whole or fractional quantity as the denominator.
     * In the case of fractional quantity this field is the denominator and quantity is the numerator.
     * When unspecified, the value is `1`. For example, when `quantity=3` and `quantity_donominator` is
     * unspecified,
     * the quantity ratio is `3` or `3/1`.
     */
    public function getQuantityDenominator(): ?int
    {
        if (count($this->quantityDenominator) == 0) {
            return null;
        }
        return $this->quantityDenominator['value'];
    }

    /**
     * Sets Quantity Denominator.
     * The whole or fractional quantity as the denominator.
     * In the case of fractional quantity this field is the denominator and quantity is the numerator.
     * When unspecified, the value is `1`. For example, when `quantity=3` and `quantity_donominator` is
     * unspecified,
     * the quantity ratio is `3` or `3/1`.
     *
     * @maps quantity_denominator
     */
    public function setQuantityDenominator(?int $quantityDenominator): void
    {
        $this->quantityDenominator['value'] = $quantityDenominator;
    }

    /**
     * Unsets Quantity Denominator.
     * The whole or fractional quantity as the denominator.
     * In the case of fractional quantity this field is the denominator and quantity is the numerator.
     * When unspecified, the value is `1`. For example, when `quantity=3` and `quantity_donominator` is
     * unspecified,
     * the quantity ratio is `3` or `3/1`.
     */
    public function unsetQuantityDenominator(): void
    {
        $this->quantityDenominator = [];
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
        if (!empty($this->quantity)) {
            $json['quantity']             = $this->quantity['value'];
        }
        if (!empty($this->quantityDenominator)) {
            $json['quantity_denominator'] = $this->quantityDenominator['value'];
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
