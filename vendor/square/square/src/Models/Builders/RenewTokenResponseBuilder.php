<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\RenewTokenResponse;

/**
 * Builder for model RenewTokenResponse
 *
 * @see RenewTokenResponse
 */
class RenewTokenResponseBuilder
{
    /**
     * @var RenewTokenResponse
     */
    private $instance;

    private function __construct(RenewTokenResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new renew token response Builder object.
     */
    public static function init(): self
    {
        return new self(new RenewTokenResponse());
    }

    /**
     * Sets access token field.
     */
    public function accessToken(?string $value): self
    {
        $this->instance->setAccessToken($value);
        return $this;
    }

    /**
     * Sets token type field.
     */
    public function tokenType(?string $value): self
    {
        $this->instance->setTokenType($value);
        return $this;
    }

    /**
     * Sets expires at field.
     */
    public function expiresAt(?string $value): self
    {
        $this->instance->setExpiresAt($value);
        return $this;
    }

    /**
     * Sets merchant id field.
     */
    public function merchantId(?string $value): self
    {
        $this->instance->setMerchantId($value);
        return $this;
    }

    /**
     * Sets subscription id field.
     */
    public function subscriptionId(?string $value): self
    {
        $this->instance->setSubscriptionId($value);
        return $this;
    }

    /**
     * Sets plan id field.
     */
    public function planId(?string $value): self
    {
        $this->instance->setPlanId($value);
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
     * Initializes a new renew token response object.
     */
    public function build(): RenewTokenResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
