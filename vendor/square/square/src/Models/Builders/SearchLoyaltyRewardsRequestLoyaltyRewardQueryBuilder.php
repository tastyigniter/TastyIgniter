<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\SearchLoyaltyRewardsRequestLoyaltyRewardQuery;

/**
 * Builder for model SearchLoyaltyRewardsRequestLoyaltyRewardQuery
 *
 * @see SearchLoyaltyRewardsRequestLoyaltyRewardQuery
 */
class SearchLoyaltyRewardsRequestLoyaltyRewardQueryBuilder
{
    /**
     * @var SearchLoyaltyRewardsRequestLoyaltyRewardQuery
     */
    private $instance;

    private function __construct(SearchLoyaltyRewardsRequestLoyaltyRewardQuery $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new search loyalty rewards request loyalty reward query Builder object.
     */
    public static function init(string $loyaltyAccountId): self
    {
        return new self(new SearchLoyaltyRewardsRequestLoyaltyRewardQuery($loyaltyAccountId));
    }

    /**
     * Sets status field.
     */
    public function status(?string $value): self
    {
        $this->instance->setStatus($value);
        return $this;
    }

    /**
     * Initializes a new search loyalty rewards request loyalty reward query object.
     */
    public function build(): SearchLoyaltyRewardsRequestLoyaltyRewardQuery
    {
        return CoreHelper::clone($this->instance);
    }
}
