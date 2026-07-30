<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\GetPayoutResponse;
use Square\Models\Payout;

/**
 * Builder for model GetPayoutResponse
 *
 * @see GetPayoutResponse
 */
class GetPayoutResponseBuilder
{
    /**
     * @var GetPayoutResponse
     */
    private $instance;

    private function __construct(GetPayoutResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new get payout response Builder object.
     */
    public static function init(): self
    {
        return new self(new GetPayoutResponse());
    }

    /**
     * Sets payout field.
     */
    public function payout(?Payout $value): self
    {
        $this->instance->setPayout($value);
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
     * Initializes a new get payout response object.
     */
    public function build(): GetPayoutResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
