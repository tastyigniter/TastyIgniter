<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\SearchLoyaltyAccountsRequestLoyaltyAccountQuery;

/**
 * Builder for model SearchLoyaltyAccountsRequestLoyaltyAccountQuery
 *
 * @see SearchLoyaltyAccountsRequestLoyaltyAccountQuery
 */
class SearchLoyaltyAccountsRequestLoyaltyAccountQueryBuilder
{
    /**
     * @var SearchLoyaltyAccountsRequestLoyaltyAccountQuery
     */
    private $instance;

    private function __construct(SearchLoyaltyAccountsRequestLoyaltyAccountQuery $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new search loyalty accounts request loyalty account query Builder object.
     */
    public static function init(): self
    {
        return new self(new SearchLoyaltyAccountsRequestLoyaltyAccountQuery());
    }

    /**
     * Sets mappings field.
     */
    public function mappings(?array $value): self
    {
        $this->instance->setMappings($value);
        return $this;
    }

    /**
     * Unsets mappings field.
     */
    public function unsetMappings(): self
    {
        $this->instance->unsetMappings();
        return $this;
    }

    /**
     * Sets customer ids field.
     */
    public function customerIds(?array $value): self
    {
        $this->instance->setCustomerIds($value);
        return $this;
    }

    /**
     * Unsets customer ids field.
     */
    public function unsetCustomerIds(): self
    {
        $this->instance->unsetCustomerIds();
        return $this;
    }

    /**
     * Initializes a new search loyalty accounts request loyalty account query object.
     */
    public function build(): SearchLoyaltyAccountsRequestLoyaltyAccountQuery
    {
        return CoreHelper::clone($this->instance);
    }
}
