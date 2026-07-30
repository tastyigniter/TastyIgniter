<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\CreateLoyaltyPromotionRequest;
use Square\Models\LoyaltyPromotion;

/**
 * Builder for model CreateLoyaltyPromotionRequest
 *
 * @see CreateLoyaltyPromotionRequest
 */
class CreateLoyaltyPromotionRequestBuilder
{
    /**
     * @var CreateLoyaltyPromotionRequest
     */
    private $instance;

    private function __construct(CreateLoyaltyPromotionRequest $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new create loyalty promotion request Builder object.
     */
    public static function init(LoyaltyPromotion $loyaltyPromotion, string $idempotencyKey): self
    {
        return new self(new CreateLoyaltyPromotionRequest($loyaltyPromotion, $idempotencyKey));
    }

    /**
     * Initializes a new create loyalty promotion request object.
     */
    public function build(): CreateLoyaltyPromotionRequest
    {
        return CoreHelper::clone($this->instance);
    }
}
