<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\SearchLoyaltyAccountsRequest;
use Square\Models\SearchLoyaltyAccountsRequestLoyaltyAccountQuery;

/**
 * Builder for model SearchLoyaltyAccountsRequest
 *
 * @see SearchLoyaltyAccountsRequest
 */
class SearchLoyaltyAccountsRequestBuilder
{
    /**
     * @var SearchLoyaltyAccountsRequest
     */
    private $instance;

    private function __construct(SearchLoyaltyAccountsRequest $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new search loyalty accounts request Builder object.
     */
    public static function init(): self
    {
        return new self(new SearchLoyaltyAccountsRequest());
    }

    /**
     * Sets query field.
     */
    public function query(?SearchLoyaltyAccountsRequestLoyaltyAccountQuery $value): self
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
     * Initializes a new search loyalty accounts request object.
     */
    public function build(): SearchLoyaltyAccountsRequest
    {
        return CoreHelper::clone($this->instance);
    }
}
