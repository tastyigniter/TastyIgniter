<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Represents an accrual rule, which defines how buyers can earn points from the base [loyalty
 * program]($m/LoyaltyProgram).
 */
class LoyaltyProgramAccrualRule implements \JsonSerializable
{
    /**
     * @var string
     */
    private $accrualType;

    /**
     * @var array
     */
    private $points = [];

    /**
     * @var LoyaltyProgramAccrualRuleVisitData|null
     */
    private $visitData;

    /**
     * @var LoyaltyProgramAccrualRuleSpendData|null
     */
    private $spendData;

    /**
     * @var LoyaltyProgramAccrualRuleItemVariationData|null
     */
    private $itemVariationData;

    /**
     * @var LoyaltyProgramAccrualRuleCategoryData|null
     */
    private $categoryData;

    /**
     * @param string $accrualType
     */
    public function __construct(string $accrualType)
    {
        $this->accrualType = $accrualType;
    }

    /**
     * Returns Accrual Type.
     * The type of the accrual rule that defines how buyers can earn points.
     */
    public function getAccrualType(): string
    {
        return $this->accrualType;
    }

    /**
     * Sets Accrual Type.
     * The type of the accrual rule that defines how buyers can earn points.
     *
     * @required
     * @maps accrual_type
     */
    public function setAccrualType(string $accrualType): void
    {
        $this->accrualType = $accrualType;
    }

    /**
     * Returns Points.
     * The number of points that
     * buyers earn based on the `accrual_type`.
     */
    public function getPoints(): ?int
    {
        if (count($this->points) == 0) {
            return null;
        }
        return $this->points['value'];
    }

    /**
     * Sets Points.
     * The number of points that
     * buyers earn based on the `accrual_type`.
     *
     * @maps points
     */
    public function setPoints(?int $points): void
    {
        $this->points['value'] = $points;
    }

    /**
     * Unsets Points.
     * The number of points that
     * buyers earn based on the `accrual_type`.
     */
    public function unsetPoints(): void
    {
        $this->points = [];
    }

    /**
     * Returns Visit Data.
     * Represents additional data for rules with the `VISIT` accrual type.
     */
    public function getVisitData(): ?LoyaltyProgramAccrualRuleVisitData
    {
        return $this->visitData;
    }

    /**
     * Sets Visit Data.
     * Represents additional data for rules with the `VISIT` accrual type.
     *
     * @maps visit_data
     */
    public function setVisitData(?LoyaltyProgramAccrualRuleVisitData $visitData): void
    {
        $this->visitData = $visitData;
    }

    /**
     * Returns Spend Data.
     * Represents additional data for rules with the `SPEND` accrual type.
     */
    public function getSpendData(): ?LoyaltyProgramAccrualRuleSpendData
    {
        return $this->spendData;
    }

    /**
     * Sets Spend Data.
     * Represents additional data for rules with the `SPEND` accrual type.
     *
     * @maps spend_data
     */
    public function setSpendData(?LoyaltyProgramAccrualRuleSpendData $spendData): void
    {
        $this->spendData = $spendData;
    }

    /**
     * Returns Item Variation Data.
     * Represents additional data for rules with the `ITEM_VARIATION` accrual type.
     */
    public function getItemVariationData(): ?LoyaltyProgramAccrualRuleItemVariationData
    {
        return $this->itemVariationData;
    }

    /**
     * Sets Item Variation Data.
     * Represents additional data for rules with the `ITEM_VARIATION` accrual type.
     *
     * @maps item_variation_data
     */
    public function setItemVariationData(?LoyaltyProgramAccrualRuleItemVariationData $itemVariationData): void
    {
        $this->itemVariationData = $itemVariationData;
    }

    /**
     * Returns Category Data.
     * Represents additional data for rules with the `CATEGORY` accrual type.
     */
    public function getCategoryData(): ?LoyaltyProgramAccrualRuleCategoryData
    {
        return $this->categoryData;
    }

    /**
     * Sets Category Data.
     * Represents additional data for rules with the `CATEGORY` accrual type.
     *
     * @maps category_data
     */
    public function setCategoryData(?LoyaltyProgramAccrualRuleCategoryData $categoryData): void
    {
        $this->categoryData = $categoryData;
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
        $json['accrual_type']            = $this->accrualType;
        if (!empty($this->points)) {
            $json['points']              = $this->points['value'];
        }
        if (isset($this->visitData)) {
            $json['visit_data']          = $this->visitData;
        }
        if (isset($this->spendData)) {
            $json['spend_data']          = $this->spendData;
        }
        if (isset($this->itemVariationData)) {
            $json['item_variation_data'] = $this->itemVariationData;
        }
        if (isset($this->categoryData)) {
            $json['category_data']       = $this->categoryData;
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
