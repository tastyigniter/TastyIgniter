<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\SearchInvoicesResponse;

/**
 * Builder for model SearchInvoicesResponse
 *
 * @see SearchInvoicesResponse
 */
class SearchInvoicesResponseBuilder
{
    /**
     * @var SearchInvoicesResponse
     */
    private $instance;

    private function __construct(SearchInvoicesResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new search invoices response Builder object.
     */
    public static function init(): self
    {
        return new self(new SearchInvoicesResponse());
    }

    /**
     * Sets invoices field.
     */
    public function invoices(?array $value): self
    {
        $this->instance->setInvoices($value);
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
     * Sets errors field.
     */
    public function errors(?array $value): self
    {
        $this->instance->setErrors($value);
        return $this;
    }

    /**
     * Initializes a new search invoices response object.
     */
    public function build(): SearchInvoicesResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
