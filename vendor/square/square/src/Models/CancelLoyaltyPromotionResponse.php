<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Represents a [CancelLoyaltyPromotion]($e/Loyalty/CancelLoyaltyPromotion) response.
 * Either `loyalty_promotion` or `errors` is present in the response.
 */
class CancelLoyaltyPromotionResponse implements \JsonSerializable
{
    /**
     * @var Error[]|null
     */
    private $errors;

    /**
     * @var LoyaltyPromotion|null
     */
    private $loyaltyPromotion;

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
     * Returns Loyalty Promotion.
     * Represents a promotion for a [loyalty program]($m/LoyaltyProgram). Loyalty promotions enable buyers
     * to earn extra points on top of those earned from the base program.
     *
     * A loyalty program can have a maximum of 10 loyalty promotions with an `ACTIVE` or `SCHEDULED` status.
     */
    public function getLoyaltyPromotion(): ?LoyaltyPromotion
    {
        return $this->loyaltyPromotion;
    }

    /**
     * Sets Loyalty Promotion.
     * Represents a promotion for a [loyalty program]($m/LoyaltyProgram). Loyalty promotions enable buyers
     * to earn extra points on top of those earned from the base program.
     *
     * A loyalty program can have a maximum of 10 loyalty promotions with an `ACTIVE` or `SCHEDULED` status.
     *
     * @maps loyalty_promotion
     */
    public function setLoyaltyPromotion(?LoyaltyPromotion $loyaltyPromotion): void
    {
        $this->loyaltyPromotion = $loyaltyPromotion;
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
            $json['errors']            = $this->errors;
        }
        if (isset($this->loyaltyPromotion)) {
            $json['loyalty_promotion'] = $this->loyaltyPromotion;
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
