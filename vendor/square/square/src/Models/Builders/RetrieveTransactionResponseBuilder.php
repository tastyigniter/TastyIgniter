<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\RetrieveTransactionResponse;
use Square\Models\Transaction;

/**
 * Builder for model RetrieveTransactionResponse
 *
 * @see RetrieveTransactionResponse
 */
class RetrieveTransactionResponseBuilder
{
    /**
     * @var RetrieveTransactionResponse
     */
    private $instance;

    private function __construct(RetrieveTransactionResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new retrieve transaction response Builder object.
     */
    public static function init(): self
    {
        return new self(new RetrieveTransactionResponse());
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
     * Sets transaction field.
     */
    public function transaction(?Transaction $value): self
    {
        $this->instance->setTransaction($value);
        return $this;
    }

    /**
     * Initializes a new retrieve transaction response object.
     */
    public function build(): RetrieveTransactionResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
