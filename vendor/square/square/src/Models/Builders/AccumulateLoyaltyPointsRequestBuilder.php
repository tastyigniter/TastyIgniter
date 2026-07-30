<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\AccumulateLoyaltyPointsRequest;
use Square\Models\LoyaltyEventAccumulatePoints;

/**
 * Builder for model AccumulateLoyaltyPointsRequest
 *
 * @see AccumulateLoyaltyPointsRequest
 */
class AccumulateLoyaltyPointsRequestBuilder
{
    /**
     * @var AccumulateLoyaltyPointsRequest
     */
    private $instance;

    private function __construct(AccumulateLoyaltyPointsRequest $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new accumulate loyalty points request Builder object.
     */
    public static function init(
        LoyaltyEventAccumulatePoints $accumulatePoints,
        string $idempotencyKey,
        string $locationId
    ): self {
        return new self(new AccumulateLoyaltyPointsRequest($accumulatePoints, $idempotencyKey, $locationId));
    }

    /**
     * Initializes a new accumulate loyalty points request object.
     */
    public function build(): AccumulateLoyaltyPointsRequest
    {
        return CoreHelper::clone($this->instance);
    }
}
