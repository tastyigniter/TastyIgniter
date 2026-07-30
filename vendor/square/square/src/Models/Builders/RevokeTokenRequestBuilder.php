<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\RevokeTokenRequest;

/**
 * Builder for model RevokeTokenRequest
 *
 * @see RevokeTokenRequest
 */
class RevokeTokenRequestBuilder
{
    /**
     * @var RevokeTokenRequest
     */
    private $instance;

    private function __construct(RevokeTokenRequest $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new revoke token request Builder object.
     */
    public static function init(): self
    {
        return new self(new RevokeTokenRequest());
    }

    /**
     * Sets client id field.
     */
    public function clientId(?string $value): self
    {
        $this->instance->setClientId($value);
        return $this;
    }

    /**
     * Unsets client id field.
     */
    public function unsetClientId(): self
    {
        $this->instance->unsetClientId();
        return $this;
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
     * Unsets access token field.
     */
    public function unsetAccessToken(): self
    {
        $this->instance->unsetAccessToken();
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
     * Unsets merchant id field.
     */
    public function unsetMerchantId(): self
    {
        $this->instance->unsetMerchantId();
        return $this;
    }

    /**
     * Sets revoke only access token field.
     */
    public function revokeOnlyAccessToken(?bool $value): self
    {
        $this->instance->setRevokeOnlyAccessToken($value);
        return $this;
    }

    /**
     * Unsets revoke only access token field.
     */
    public function unsetRevokeOnlyAccessToken(): self
    {
        $this->instance->unsetRevokeOnlyAccessToken();
        return $this;
    }

    /**
     * Initializes a new revoke token request object.
     */
    public function build(): RevokeTokenRequest
    {
        return CoreHelper::clone($this->instance);
    }
}
