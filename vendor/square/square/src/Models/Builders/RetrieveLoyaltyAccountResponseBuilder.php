<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\LoyaltyAccount;
use Square\Models\RetrieveLoyaltyAccountResponse;

/**
 * Builder for model RetrieveLoyaltyAccountResponse
 *
 * @see RetrieveLoyaltyAccountResponse
 */
class RetrieveLoyaltyAccountResponseBuilder
{
    /**
     * @var RetrieveLoyaltyAccountResponse
     */
    private $instance;

    private function __construct(RetrieveLoyaltyAccountResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new retrieve loyalty account response Builder object.
     */
    public static function init(): self
    {
        return new self(new RetrieveLoyaltyAccountResponse());
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
     * Initializes a new retrieve loyalty account response object.
     */
    public function build(): RetrieveLoyaltyAccountResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
