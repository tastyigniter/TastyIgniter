<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\SearchLoyaltyAccountsResponse;

/**
 * Builder for model SearchLoyaltyAccountsResponse
 *
 * @see SearchLoyaltyAccountsResponse
 */
class SearchLoyaltyAccountsResponseBuilder
{
    /**
     * @var SearchLoyaltyAccountsResponse
     */
    private $instance;

    private function __construct(SearchLoyaltyAccountsResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new search loyalty accounts response Builder object.
     */
    public static function init(): self
    {
        return new self(new SearchLoyaltyAccountsResponse());
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
     * Sets loyalty accounts field.
     */
    public function loyaltyAccounts(?array $value): self
    {
        $this->instance->setLoyaltyAccounts($value);
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
     * Initializes a new search loyalty accounts response object.
     */
    public function build(): SearchLoyaltyAccountsResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
