<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\ChargeResponse;
use Square\Models\Transaction;

/**
 * Builder for model ChargeResponse
 *
 * @see ChargeResponse
 */
class ChargeResponseBuilder
{
    /**
     * @var ChargeResponse
     */
    private $instance;

    private function __construct(ChargeResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new charge response Builder object.
     */
    public static function init(): self
    {
        return new self(new ChargeResponse());
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
     * Initializes a new charge response object.
     */
    public function build(): ChargeResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
