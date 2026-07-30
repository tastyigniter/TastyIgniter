<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\Card;
use Square\Models\CreateCustomerCardResponse;

/**
 * Builder for model CreateCustomerCardResponse
 *
 * @see CreateCustomerCardResponse
 */
class CreateCustomerCardResponseBuilder
{
    /**
     * @var CreateCustomerCardResponse
     */
    private $instance;

    private function __construct(CreateCustomerCardResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new create customer card response Builder object.
     */
    public static function init(): self
    {
        return new self(new CreateCustomerCardResponse());
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
     * Sets card field.
     */
    public function card(?Card $value): self
    {
        $this->instance->setCard($value);
        return $this;
    }

    /**
     * Initializes a new create customer card response object.
     */
    public function build(): CreateCustomerCardResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
