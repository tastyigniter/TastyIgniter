<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\SearchLoyaltyRewardsResponse;

/**
 * Builder for model SearchLoyaltyRewardsResponse
 *
 * @see SearchLoyaltyRewardsResponse
 */
class SearchLoyaltyRewardsResponseBuilder
{
    /**
     * @var SearchLoyaltyRewardsResponse
     */
    private $instance;

    private function __construct(SearchLoyaltyRewardsResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new search loyalty rewards response Builder object.
     */
    public static function init(): self
    {
        return new self(new SearchLoyaltyRewardsResponse());
    }

    /**
     * Sets errors field.
     */
    public function errors(?array $value): self
    {
        $this->instance->setErrors($value);
        return $this;
    }

    /**
     * Sets rewards field.
     */
    public function rewards(?array $value): self
    {
        $this->instance->setRewards($value);
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
     * Initializes a new search loyalty rewards response object.
     */
    public function build(): SearchLoyaltyRewardsResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
