<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\SearchLoyaltyRewardsRequest;
use Square\Models\SearchLoyaltyRewardsRequestLoyaltyRewardQuery;

/**
 * Builder for model SearchLoyaltyRewardsRequest
 *
 * @see SearchLoyaltyRewardsRequest
 */
class SearchLoyaltyRewardsRequestBuilder
{
    /**
     * @var SearchLoyaltyRewardsRequest
     */
    private $instance;

    private function __construct(SearchLoyaltyRewardsRequest $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new search loyalty rewards request Builder object.
     */
    public static function init(): self
    {
        return new self(new SearchLoyaltyRewardsRequest());
    }

    /**
     * Sets query field.
     */
    public function query(?SearchLoyaltyRewardsRequestLoyaltyRewardQuery $value): self
    {
        $this->instance->setQuery($value);
        return $this;
    }

    /**
     * Sets limit field.
     */
    public function limit(?int $value): self
    {
        $this->instance->setLimit($value);
        return $this;
    }

    /**
     * Sets cursor field.
     */
    public function cursor(?string $value): self
    {
        $this->instance->setCursor($value);
        return $this;
    }

    /**
     * Initializes a new search loyalty rewards request object.
     */
    public function build(): SearchLoyaltyRewardsRequest
    {
        return CoreHelper::clone($this->instance);
    }
}
