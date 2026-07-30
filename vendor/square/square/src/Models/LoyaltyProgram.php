<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Represents a Square loyalty program. Loyalty programs define how buyers can earn points and redeem
 * points for rewards.
 * Square sellers can have only one loyalty program, which is created and managed from the Seller
 * Dashboard.
 * For more information, see [Loyalty Program Overview](https://developer.squareup.
 * com/docs/loyalty/overview).
 */
class LoyaltyProgram implements \JsonSerializable
{
    /**
     * @var string|null
     */
    private $id;

    /**
     * @var string|null
     */
    private $status;

    /**
     * @var array
     */
    private $rewardTiers = [];

    /**
     * @var LoyaltyProgramExpirationPolicy|null
     */
    private $expirationPolicy;

    /**
     * @var LoyaltyProgramTerminology|null
     */
    private $terminology;

    /**
     * @var array
     */
    private $locationIds = [];

    /**
     * @var string|null
     */
    private $createdAt;

    /**
     * @var string|null
     */
    private $updatedAt;

    /**
     * @var array
     */
    private $accrualRules = [];

    /**
     * Returns Id.
     * The Square-assigned ID of the loyalty program. Updates to
     * the loyalty program do not modify the identifier.
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * Sets Id.
     * The Square-assigned ID of the loyalty program. Updates to
     * the loyalty program do not modify the identifier.
     *
     * @maps id
     */
    public function setId(?string $id): void
    {
        $this->id = $id;
    }

    /**
     * Returns Status.
     * Indicates whether the program is currently active.
     */
    public function getStatus(): ?string
    {
        return $this->status;
    }

    /**
     * Sets Status.
     * Indicates whether the program is currently active.
     *
     * @maps status
     */
    public function setStatus(?string $status): void
    {
        $this->status = $status;
    }

    /**
     * Returns Reward Tiers.
     * The list of rewards for buyers, sorted by ascending points.
     *
     * @return LoyaltyProgramRewardTier[]|null
     */
    public function getRewardTiers(): ?array
    {
        if (count($this->rewardTiers) == 0) {
            return null;
        }
        return $this->rewardTiers['value'];
    }

    /**
     * Sets Reward Tiers.
     * The list of rewards for buyers, sorted by ascending points.
     *
     * @maps reward_tiers
     *
     * @param LoyaltyProgramRewardTier[]|null $rewardTiers
     */
    public function setRewardTiers(?array $rewardTiers): void
    {
        $this->rewardTiers['value'] = $rewardTiers;
    }

    /**
     * Unsets Reward Tiers.
     * The list of rewards for buyers, sorted by ascending points.
     */
    public function unsetRewardTiers(): void
    {
        $this->rewardTiers = [];
    }

    /**
     * Returns Expiration Policy.
     * Describes when the loyalty program expires.
     */
    public function getExpirationPolicy(): ?LoyaltyProgramExpirationPolicy
    {
        return $this->expirationPolicy;
    }

    /**
     * Sets Expiration Policy.
     * Describes when the loyalty program expires.
     *
     * @maps expiration_policy
     */
    public function setExpirationPolicy(?LoyaltyProgramExpirationPolicy $expirationPolicy): void
    {
        $this->expirationPolicy = $expirationPolicy;
    }

    /**
     * Returns Terminology.
     * Represents the naming used for loyalty points.
     */
    public function getTerminology(): ?LoyaltyProgramTerminology
    {
        return $this->terminology;
    }

    /**
     * Sets Terminology.
     * Represents the naming used for loyalty points.
     *
     * @maps terminology
     */
    public function setTerminology(?LoyaltyProgramTerminology $terminology): void
    {
        $this->terminology = $terminology;
    }

    /**
     * Returns Location Ids.
     * The [locations](entity:Location) at which the program is active.
     *
     * @return string[]|null
     */
    public function getLocationIds(): ?array
    {
        if (count($this->locationIds) == 0) {
            return null;
        }
        return $this->locationIds['value'];
    }

    /**
     * Sets Location Ids.
     * The [locations](entity:Location) at which the program is active.
     *
     * @maps location_ids
     *
     * @param string[]|null $locationIds
     */
    public function setLocationIds(?array $locationIds): void
    {
        $this->locationIds['value'] = $locationIds;
    }

    /**
     * Unsets Location Ids.
     * The [locations](entity:Location) at which the program is active.
     */
    public function unsetLocationIds(): void
    {
        $this->locationIds = [];
    }

    /**
     * Returns Created At.
     * The timestamp when the program was created, in RFC 3339 format.
     */
    public function getCreatedAt(): ?string
    {
        return $this->createdAt;
    }

    /**
     * Sets Created At.
     * The timestamp when the program was created, in RFC 3339 format.
     *
     * @maps created_at
     */
    public function setCreatedAt(?string $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * Returns Updated At.
     * The timestamp when the reward was last updated, in RFC 3339 format.
     */
    public function getUpdatedAt(): ?string
    {
        return $this->updatedAt;
    }

    /**
     * Sets Updated At.
     * The timestamp when the reward was last updated, in RFC 3339 format.
     *
     * @maps updated_at
     */
    public function setUpdatedAt(?string $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * Returns Accrual Rules.
     * Defines how buyers can earn loyalty points from the base loyalty program.
     * To check for associated [loyalty promotions](entity:LoyaltyPromotion) that enable
     * buyers to earn extra points, call [ListLoyaltyPromotions](api-endpoint:Loyalty-
     * ListLoyaltyPromotions).
     *
     * @return LoyaltyProgramAccrualRule[]|null
     */
    public function getAccrualRules(): ?array
    {
        if (count($this->accrualRules) == 0) {
            return null;
        }
        return $this->accrualRules['value'];
    }

    /**
     * Sets Accrual Rules.
     * Defines how buyers can earn loyalty points from the base loyalty program.
     * To check for associated [loyalty promotions](entity:LoyaltyPromotion) that enable
     * buyers to earn extra points, call [ListLoyaltyPromotions](api-endpoint:Loyalty-
     * ListLoyaltyPromotions).
     *
     * @maps accrual_rules
     *
     * @param LoyaltyProgramAccrualRule[]|null $accrualRules
     */
    public function setAccrualRules(?array $accrualRules): void
    {
        $this->accrualRules['value'] = $accrualRules;
    }

    /**
     * Unsets Accrual Rules.
     * Defines how buyers can earn loyalty points from the base loyalty program.
     * To check for associated [loyalty promotions](entity:LoyaltyPromotion) that enable
     * buyers to earn extra points, call [ListLoyaltyPromotions](api-endpoint:Loyalty-
     * ListLoyaltyPromotions).
     */
    public function unsetAccrualRules(): void
    {
        $this->accrualRules = [];
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
        if (isset($this->id)) {
            $json['id']                = $this->id;
        }
        if (isset($this->status)) {
            $json['status']            = $this->status;
        }
        if (!empty($this->rewardTiers)) {
            $json['reward_tiers']      = $this->rewardTiers['value'];
        }
        if (isset($this->expirationPolicy)) {
            $json['expiration_policy'] = $this->expirationPolicy;
        }
        if (isset($this->terminology)) {
            $json['terminology']       = $this->terminology;
        }
        if (!empty($this->locationIds)) {
            $json['location_ids']      = $this->locationIds['value'];
        }
        if (isset($this->createdAt)) {
            $json['created_at']        = $this->createdAt;
        }
        if (isset($this->updatedAt)) {
            $json['updated_at']        = $this->updatedAt;
        }
        if (!empty($this->accrualRules)) {
            $json['accrual_rules']     = $this->accrualRules['value'];
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
