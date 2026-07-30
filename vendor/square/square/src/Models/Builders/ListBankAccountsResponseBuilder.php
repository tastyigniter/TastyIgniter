<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\ListBankAccountsResponse;

/**
 * Builder for model ListBankAccountsResponse
 *
 * @see ListBankAccountsResponse
 */
class ListBankAccountsResponseBuilder
{
    /**
     * @var ListBankAccountsResponse
     */
    private $instance;

    private function __construct(ListBankAccountsResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new list bank accounts response Builder object.
     */
    public static function init(): self
    {
        return new self(new ListBankAccountsResponse());
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
     * Sets bank accounts field.
     */
    public function bankAccounts(?array $value): self
    {
        $this->instance->setBankAccounts($value);
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
     * Initializes a new list bank accounts response object.
     */
    public function build(): ListBankAccountsResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
