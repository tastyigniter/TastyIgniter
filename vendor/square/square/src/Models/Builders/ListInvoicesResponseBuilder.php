<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\ListInvoicesResponse;

/**
 * Builder for model ListInvoicesResponse
 *
 * @see ListInvoicesResponse
 */
class ListInvoicesResponseBuilder
{
    /**
     * @var ListInvoicesResponse
     */
    private $instance;

    private function __construct(ListInvoicesResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new list invoices response Builder object.
     */
    public static function init(): self
    {
        return new self(new ListInvoicesResponse());
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
     * Initializes a new list invoices response object.
     */
    public function build(): ListInvoicesResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
