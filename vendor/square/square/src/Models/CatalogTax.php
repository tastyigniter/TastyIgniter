<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * A tax applicable to an item.
 */
class CatalogTax implements \JsonSerializable
{
    /**
     * @var array
     */
    private $name = [];

    /**
     * @var string|null
     */
    private $calculationPhase;

    /**
     * @var string|null
     */
    private $inclusionType;

    /**
     * @var array
     */
    private $percentage = [];

    /**
     * @var array
     */
    private $appliesToCustomAmounts = [];

    /**
     * @var array
     */
    private $enabled = [];

    /**
     * Returns Name.
     * The tax's name. This is a searchable attribute for use in applicable query filters, and its value
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
     * The tax's name. This is a searchable attribute for use in applicable query filters, and its value
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
     * The tax's name. This is a searchable attribute for use in applicable query filters, and its value
     * length is of Unicode code points.
     */
    public function unsetName(): void
    {
        $this->name = [];
    }

    /**
     * Returns Calculation Phase.
     * When to calculate the taxes due on a cart.
     */
    public function getCalculationPhase(): ?string
    {
        return $this->calculationPhase;
    }

    /**
     * Sets Calculation Phase.
     * When to calculate the taxes due on a cart.
     *
     * @maps calculation_phase
     */
    public function setCalculationPhase(?string $calculationPhase): void
    {
        $this->calculationPhase = $calculationPhase;
    }

    /**
     * Returns Inclusion Type.
     * Whether to the tax amount should be additional to or included in the CatalogItem price.
     */
    public function getInclusionType(): ?string
    {
        return $this->inclusionType;
    }

    /**
     * Sets Inclusion Type.
     * Whether to the tax amount should be additional to or included in the CatalogItem price.
     *
     * @maps inclusion_type
     */
    public function setInclusionType(?string $inclusionType): void
    {
        $this->inclusionType = $inclusionType;
    }

    /**
     * Returns Percentage.
     * The percentage of the tax in decimal form, using a `'.'` as the decimal separator and without a
     * `'%'` sign.
     * A value of `7.5` corresponds to 7.5%. For a location-specific tax rate, contact the tax authority of
     * the location or a tax consultant.
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
     * The percentage of the tax in decimal form, using a `'.'` as the decimal separator and without a
     * `'%'` sign.
     * A value of `7.5` corresponds to 7.5%. For a location-specific tax rate, contact the tax authority of
     * the location or a tax consultant.
     *
     * @maps percentage
     */
    public function setPercentage(?string $percentage): void
    {
        $this->percentage['value'] = $percentage;
    }

    /**
     * Unsets Percentage.
     * The percentage of the tax in decimal form, using a `'.'` as the decimal separator and without a
     * `'%'` sign.
     * A value of `7.5` corresponds to 7.5%. For a location-specific tax rate, contact the tax authority of
     * the location or a tax consultant.
     */
    public function unsetPercentage(): void
    {
        $this->percentage = [];
    }

    /**
     * Returns Applies to Custom Amounts.
     * If `true`, the fee applies to custom amounts entered into the Square Point of Sale
     * app that are not associated with a particular `CatalogItem`.
     */
    public function getAppliesToCustomAmounts(): ?bool
    {
        if (count($this->appliesToCustomAmounts) == 0) {
            return null;
        }
        return $this->appliesToCustomAmounts['value'];
    }

    /**
     * Sets Applies to Custom Amounts.
     * If `true`, the fee applies to custom amounts entered into the Square Point of Sale
     * app that are not associated with a particular `CatalogItem`.
     *
     * @maps applies_to_custom_amounts
     */
    public function setAppliesToCustomAmounts(?bool $appliesToCustomAmounts): void
    {
        $this->appliesToCustomAmounts['value'] = $appliesToCustomAmounts;
    }

    /**
     * Unsets Applies to Custom Amounts.
     * If `true`, the fee applies to custom amounts entered into the Square Point of Sale
     * app that are not associated with a particular `CatalogItem`.
     */
    public function unsetAppliesToCustomAmounts(): void
    {
        $this->appliesToCustomAmounts = [];
    }

    /**
     * Returns Enabled.
     * A Boolean flag to indicate whether the tax is displayed as enabled (`true`) in the Square Point of
     * Sale app or not (`false`).
     */
    public function getEnabled(): ?bool
    {
        if (count($this->enabled) == 0) {
            return null;
        }
        return $this->enabled['value'];
    }

    /**
     * Sets Enabled.
     * A Boolean flag to indicate whether the tax is displayed as enabled (`true`) in the Square Point of
     * Sale app or not (`false`).
     *
     * @maps enabled
     */
    public function setEnabled(?bool $enabled): void
    {
        $this->enabled['value'] = $enabled;
    }

    /**
     * Unsets Enabled.
     * A Boolean flag to indicate whether the tax is displayed as enabled (`true`) in the Square Point of
     * Sale app or not (`false`).
     */
    public function unsetEnabled(): void
    {
        $this->enabled = [];
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
            $json['name']                      = $this->name['value'];
        }
        if (isset($this->calculationPhase)) {
            $json['calculation_phase']         = $this->calculationPhase;
        }
        if (isset($this->inclusionType)) {
            $json['inclusion_type']            = $this->inclusionType;
        }
        if (!empty($this->percentage)) {
            $json['percentage']                = $this->percentage['value'];
        }
        if (!empty($this->appliesToCustomAmounts)) {
            $json['applies_to_custom_amounts'] = $this->appliesToCustomAmounts['value'];
        }
        if (!empty($this->enabled)) {
            $json['enabled']                   = $this->enabled['value'];
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
