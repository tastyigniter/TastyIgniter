<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * A response that includes the loyalty reward created.
 */
class CreateLoyaltyRewardResponse implements \JsonSerializable
{
    /**
     * @var Error[]|null
     */
    private $errors;

    /**
     * @var LoyaltyReward|null
     */
    private $reward;

    /**
     * Returns Errors.
     * Any errors that occurred during the request.
     *
     * @return Error[]|null
     */
    public function getErrors(): ?array
    {
        return $this->errors;
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
        $this->errors = $errors;
    }

    /**
     * Returns Reward.
     * Represents a contract to redeem loyalty points for a [reward tier]($m/LoyaltyProgramRewardTier)
     * discount. Loyalty rewards can be in an ISSUED, REDEEMED, or DELETED state.
     * For more information, see [Manage loyalty rewards](https://developer.squareup.com/docs/loyalty-
     * api/loyalty-rewards).
     */
    public function getReward(): ?LoyaltyReward
    {
        return $this->reward;
    }

    /**
     * Sets Reward.
     * Represents a contract to redeem loyalty points for a [reward tier]($m/LoyaltyProgramRewardTier)
     * discount. Loyalty rewards can be in an ISSUED, REDEEMED, or DELETED state.
     * For more information, see [Manage loyalty rewards](https://developer.squareup.com/docs/loyalty-
     * api/loyalty-rewards).
     *
     * @maps reward
     */
    public function setReward(?LoyaltyReward $reward): void
    {
        $this->reward = $reward;
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
        if (isset($this->errors)) {
            $json['errors'] = $this->errors;
        }
        if (isset($this->reward)) {
            $json['reward'] = $this->reward;
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
