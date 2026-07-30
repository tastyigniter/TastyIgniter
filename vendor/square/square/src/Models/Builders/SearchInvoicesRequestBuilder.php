<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\InvoiceQuery;
use Square\Models\SearchInvoicesRequest;

/**
 * Builder for model SearchInvoicesRequest
 *
 * @see SearchInvoicesRequest
 */
class SearchInvoicesRequestBuilder
{
    /**
     * @var SearchInvoicesRequest
     */
    private $instance;

    private function __construct(SearchInvoicesRequest $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new search invoices request Builder object.
     */
    public static function init(InvoiceQuery $query): self
    {
        return new self(new SearchInvoicesRequest($query));
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
     * Initializes a new search invoices request object.
     */
    public function build(): SearchInvoicesRequest
    {
        return CoreHelper::clone($this->instance);
    }
}
