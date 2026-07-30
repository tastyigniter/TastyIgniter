<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\CreateLoyaltyAccountResponse;
use Square\Models\LoyaltyAccount;

/**
 * Builder for model CreateLoyaltyAccountResponse
 *
 * @see CreateLoyaltyAccountResponse
 */
class CreateLoyaltyAccountResponseBuilder
{
    /**
     * @var CreateLoyaltyAccountResponse
     */
    private $instance;

    private function __construct(CreateLoyaltyAccountResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new create loyalty account response Builder object.
     */
    public static function init(): self
    {
        return new self(new CreateLoyaltyAccountResponse());
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
     * Sets loyalty account field.
     */
    public function loyaltyAccount(?LoyaltyAccount $value): self
    {
        $this->instance->setLoyaltyAccount($value);
        return $this;
    }

    /**
     * Initializes a new create loyalty account response object.
     */
    public function build(): CreateLoyaltyAccountResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
