<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * A parent Catalog Object model represents a set of Quick Amounts and the settings control the amounts.
 */
class CatalogQuickAmountsSettings implements \JsonSerializable
{
    /**
     * @var string
     */
    private $option;

    /**
     * @var array
     */
    private $eligibleForAutoAmounts = [];

    /**
     * @var array
     */
    private $amounts = [];

    /**
     * @param string $option
     */
    public function __construct(string $option)
    {
        $this->option = $option;
    }

    /**
     * Returns Option.
     * Determines a seller's option on Quick Amounts feature.
     */
    public function getOption(): string
    {
        return $this->option;
    }

    /**
     * Sets Option.
     * Determines a seller's option on Quick Amounts feature.
     *
     * @required
     * @maps option
     */
    public function setOption(string $option): void
    {
        $this->option = $option;
    }

    /**
     * Returns Eligible for Auto Amounts.
     * Represents location's eligibility for auto amounts
     * The boolean should be consistent with whether there are AUTO amounts in the `amounts`.
     */
    public function getEligibleForAutoAmounts(): ?bool
    {
        if (count($this->eligibleForAutoAmounts) == 0) {
            return null;
        }
        return $this->eligibleForAutoAmounts['value'];
    }

    /**
     * Sets Eligible for Auto Amounts.
     * Represents location's eligibility for auto amounts
     * The boolean should be consistent with whether there are AUTO amounts in the `amounts`.
     *
     * @maps eligible_for_auto_amounts
     */
    public function setEligibleForAutoAmounts(?bool $eligibleForAutoAmounts): void
    {
        $this->eligibleForAutoAmounts['value'] = $eligibleForAutoAmounts;
    }

    /**
     * Unsets Eligible for Auto Amounts.
     * Represents location's eligibility for auto amounts
     * The boolean should be consistent with whether there are AUTO amounts in the `amounts`.
     */
    public function unsetEligibleForAutoAmounts(): void
    {
        $this->eligibleForAutoAmounts = [];
    }

    /**
     * Returns Amounts.
     * Represents a set of Quick Amounts at this location.
     *
     * @return CatalogQuickAmount[]|null
     */
    public function getAmounts(): ?array
    {
        if (count($this->amounts) == 0) {
            return null;
        }
        return $this->amounts['value'];
    }

    /**
     * Sets Amounts.
     * Represents a set of Quick Amounts at this location.
     *
     * @maps amounts
     *
     * @param CatalogQuickAmount[]|null $amounts
     */
    public function setAmounts(?array $amounts): void
    {
        $this->amounts['value'] = $amounts;
    }

    /**
     * Unsets Amounts.
     * Represents a set of Quick Amounts at this location.
     */
    public function unsetAmounts(): void
    {
        $this->amounts = [];
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
        $json['option']                        = $this->option;
        if (!empty($this->eligibleForAutoAmounts)) {
            $json['eligible_for_auto_amounts'] = $this->eligibleForAutoAmounts['value'];
        }
        if (!empty($this->amounts)) {
            $json['amounts']                   = $this->amounts['value'];
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
