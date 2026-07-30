<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\BankAccount;
use Square\Models\GetBankAccountResponse;

/**
 * Builder for model GetBankAccountResponse
 *
 * @see GetBankAccountResponse
 */
class GetBankAccountResponseBuilder
{
    /**
     * @var GetBankAccountResponse
     */
    private $instance;

    private function __construct(GetBankAccountResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new get bank account response Builder object.
     */
    public static function init(): self
    {
        return new self(new GetBankAccountResponse());
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
     * Sets bank account field.
     */
    public function bankAccount(?BankAccount $value): self
    {
        $this->instance->setBankAccount($value);
        return $this;
    }

    /**
     * Initializes a new get bank account response object.
     */
    public function build(): GetBankAccountResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
