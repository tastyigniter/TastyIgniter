<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\CreateRefundRequest;
use Square\Models\Money;

/**
 * Builder for model CreateRefundRequest
 *
 * @see CreateRefundRequest
 */
class CreateRefundRequestBuilder
{
    /**
     * @var CreateRefundRequest
     */
    private $instance;

    private function __construct(CreateRefundRequest $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new create refund request Builder object.
     */
    public static function init(string $idempotencyKey, string $tenderId, Money $amountMoney): self
    {
        return new self(new CreateRefundRequest($idempotencyKey, $tenderId, $amountMoney));
    }

    /**
     * Sets reason field.
     */
    public function reason(?string $value): self
    {
        $this->instance->setReason($value);
        return $this;
    }

    /**
     * Initializes a new create refund request object.
     */
    public function build(): CreateRefundRequest
    {
        return CoreHelper::clone($this->instance);
    }
}
