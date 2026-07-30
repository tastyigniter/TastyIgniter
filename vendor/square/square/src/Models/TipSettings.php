<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

class TipSettings implements \JsonSerializable
{
    /**
     * @var array
     */
    private $allowTipping = [];

    /**
     * @var array
     */
    private $separateTipScreen = [];

    /**
     * @var array
     */
    private $customTipField = [];

    /**
     * @var array
     */
    private $tipPercentages = [];

    /**
     * @var array
     */
    private $smartTipping = [];

    /**
     * Returns Allow Tipping.
     * Indicates whether tipping is enabled for this checkout. Defaults to false.
     */
    public function getAllowTipping(): ?bool
    {
        if (count($this->allowTipping) == 0) {
            return null;
        }
        return $this->allowTipping['value'];
    }

    /**
     * Sets Allow Tipping.
     * Indicates whether tipping is enabled for this checkout. Defaults to false.
     *
     * @maps allow_tipping
     */
    public function setAllowTipping(?bool $allowTipping): void
    {
        $this->allowTipping['value'] = $allowTipping;
    }

    /**
     * Unsets Allow Tipping.
     * Indicates whether tipping is enabled for this checkout. Defaults to false.
     */
    public function unsetAllowTipping(): void
    {
        $this->allowTipping = [];
    }

    /**
     * Returns Separate Tip Screen.
     * Indicates whether tip options should be presented on the screen before presenting
     * the signature screen during card payment. Defaults to false.
     */
    public function getSeparateTipScreen(): ?bool
    {
        if (count($this->separateTipScreen) == 0) {
            return null;
        }
        return $this->separateTipScreen['value'];
    }

    /**
     * Sets Separate Tip Screen.
     * Indicates whether tip options should be presented on the screen before presenting
     * the signature screen during card payment. Defaults to false.
     *
     * @maps separate_tip_screen
     */
    public function setSeparateTipScreen(?bool $separateTipScreen): void
    {
        $this->separateTipScreen['value'] = $separateTipScreen;
    }

    /**
     * Unsets Separate Tip Screen.
     * Indicates whether tip options should be presented on the screen before presenting
     * the signature screen during card payment. Defaults to false.
     */
    public function unsetSeparateTipScreen(): void
    {
        $this->separateTipScreen = [];
    }

    /**
     * Returns Custom Tip Field.
     * Indicates whether custom tip amounts are allowed during the checkout flow. Defaults to false.
     */
    public function getCustomTipField(): ?bool
    {
        if (count($this->customTipField) == 0) {
            return null;
        }
        return $this->customTipField['value'];
    }

    /**
     * Sets Custom Tip Field.
     * Indicates whether custom tip amounts are allowed during the checkout flow. Defaults to false.
     *
     * @maps custom_tip_field
     */
    public function setCustomTipField(?bool $customTipField): void
    {
        $this->customTipField['value'] = $customTipField;
    }

    /**
     * Unsets Custom Tip Field.
     * Indicates whether custom tip amounts are allowed during the checkout flow. Defaults to false.
     */
    public function unsetCustomTipField(): void
    {
        $this->customTipField = [];
    }

    /**
     * Returns Tip Percentages.
     * A list of tip percentages that should be presented during the checkout flow, specified as
     * up to 3 non-negative integers from 0 to 100 (inclusive). Defaults to 15, 20, and 25.
     *
     * @return int[]|null
     */
    public function getTipPercentages(): ?array
    {
        if (count($this->tipPercentages) == 0) {
            return null;
        }
        return $this->tipPercentages['value'];
    }

    /**
     * Sets Tip Percentages.
     * A list of tip percentages that should be presented during the checkout flow, specified as
     * up to 3 non-negative integers from 0 to 100 (inclusive). Defaults to 15, 20, and 25.
     *
     * @maps tip_percentages
     *
     * @param int[]|null $tipPercentages
     */
    public function setTipPercentages(?array $tipPercentages): void
    {
        $this->tipPercentages['value'] = $tipPercentages;
    }

    /**
     * Unsets Tip Percentages.
     * A list of tip percentages that should be presented during the checkout flow, specified as
     * up to 3 non-negative integers from 0 to 100 (inclusive). Defaults to 15, 20, and 25.
     */
    public function unsetTipPercentages(): void
    {
        $this->tipPercentages = [];
    }

    /**
     * Returns Smart Tipping.
     * Enables the "Smart Tip Amounts" behavior.
     * Exact tipping options depend on the region in which the Square seller is active.
     *
     * For payments under 10.00, in the Australia, Canada, Ireland, United Kingdom, and United States,
     * tipping options are presented as no tip, .50, 1.00 or 2.00.
     *
     * For payment amounts of 10.00 or greater, tipping options are presented as the following percentages:
     * 0%, 5%, 10%, 15%.
     *
     * If set to true, the `tip_percentages` settings is ignored.
     * Defaults to false.
     *
     * To learn more about smart tipping, see [Accept Tips with the Square App](https://squareup.
     * com/help/us/en/article/5069-accept-tips-with-the-square-app).
     */
    public function getSmartTipping(): ?bool
    {
        if (count($this->smartTipping) == 0) {
            return null;
        }
        return $this->smartTipping['value'];
    }

    /**
     * Sets Smart Tipping.
     * Enables the "Smart Tip Amounts" behavior.
     * Exact tipping options depend on the region in which the Square seller is active.
     *
     * For payments under 10.00, in the Australia, Canada, Ireland, United Kingdom, and United States,
     * tipping options are presented as no tip, .50, 1.00 or 2.00.
     *
     * For payment amounts of 10.00 or greater, tipping options are presented as the following percentages:
     * 0%, 5%, 10%, 15%.
     *
     * If set to true, the `tip_percentages` settings is ignored.
     * Defaults to false.
     *
     * To learn more about smart tipping, see [Accept Tips with the Square App](https://squareup.
     * com/help/us/en/article/5069-accept-tips-with-the-square-app).
     *
     * @maps smart_tipping
     */
    public function setSmartTipping(?bool $smartTipping): void
    {
        $this->smartTipping['value'] = $smartTipping;
    }

    /**
     * Unsets Smart Tipping.
     * Enables the "Smart Tip Amounts" behavior.
     * Exact tipping options depend on the region in which the Square seller is active.
     *
     * For payments under 10.00, in the Australia, Canada, Ireland, United Kingdom, and United States,
     * tipping options are presented as no tip, .50, 1.00 or 2.00.
     *
     * For payment amounts of 10.00 or greater, tipping options are presented as the following percentages:
     * 0%, 5%, 10%, 15%.
     *
     * If set to true, the `tip_percentages` settings is ignored.
     * Defaults to false.
     *
     * To learn more about smart tipping, see [Accept Tips with the Square App](https://squareup.
     * com/help/us/en/article/5069-accept-tips-with-the-square-app).
     */
    public function unsetSmartTipping(): void
    {
        $this->smartTipping = [];
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
        if (!empty($this->allowTipping)) {
            $json['allow_tipping']       = $this->allowTipping['value'];
        }
        if (!empty($this->separateTipScreen)) {
            $json['separate_tip_screen'] = $this->separateTipScreen['value'];
        }
        if (!empty($this->customTipField)) {
            $json['custom_tip_field']    = $this->customTipField['value'];
        }
        if (!empty($this->tipPercentages)) {
            $json['tip_percentages']     = $this->tipPercentages['value'];
        }
        if (!empty($this->smartTipping)) {
            $json['smart_tipping']       = $this->smartTipping['value'];
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
