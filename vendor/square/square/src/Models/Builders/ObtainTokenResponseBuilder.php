<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\ObtainTokenResponse;

/**
 * Builder for model ObtainTokenResponse
 *
 * @see ObtainTokenResponse
 */
class ObtainTokenResponseBuilder
{
    /**
     * @var ObtainTokenResponse
     */
    private $instance;

    private function __construct(ObtainTokenResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new obtain token response Builder object.
     */
    public static function init(): self
    {
        return new self(new ObtainTokenResponse());
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
     * Sets id token field.
     */
    public function idToken(?string $value): self
    {
        $this->instance->setIdToken($value);
        return $this;
    }

    /**
     * Sets refresh token field.
     */
    public function refreshToken(?string $value): self
    {
        $this->instance->setRefreshToken($value);
        return $this;
    }

    /**
     * Sets short lived field.
     */
    public function shortLived(?bool $value): self
    {
        $this->instance->setShortLived($value);
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
     * Sets refresh token expires at field.
     */
    public function refreshTokenExpiresAt(?string $value): self
    {
        $this->instance->setRefreshTokenExpiresAt($value);
        return $this;
    }

    /**
     * Initializes a new obtain token response object.
     */
    public function build(): ObtainTokenResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
