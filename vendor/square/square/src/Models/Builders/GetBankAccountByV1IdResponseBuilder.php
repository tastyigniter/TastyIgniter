<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\BankAccount;
use Square\Models\GetBankAccountByV1IdResponse;

/**
 * Builder for model GetBankAccountByV1IdResponse
 *
 * @see GetBankAccountByV1IdResponse
 */
class GetBankAccountByV1IdResponseBuilder
{
    /**
     * @var GetBankAccountByV1IdResponse
     */
    private $instance;

    private function __construct(GetBankAccountByV1IdResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new get bank account by v1 id response Builder object.
     */
    public static function init(): self
    {
        return new self(new GetBankAccountByV1IdResponse());
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
     * Initializes a new get bank account by v1 id response object.
     */
    public function build(): GetBankAccountByV1IdResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
