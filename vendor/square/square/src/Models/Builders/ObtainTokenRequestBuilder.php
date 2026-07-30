<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\ObtainTokenRequest;

/**
 * Builder for model ObtainTokenRequest
 *
 * @see ObtainTokenRequest
 */
class ObtainTokenRequestBuilder
{
    /**
     * @var ObtainTokenRequest
     */
    private $instance;

    private function __construct(ObtainTokenRequest $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new obtain token request Builder object.
     */
    public static function init(string $clientId, string $grantType): self
    {
        return new self(new ObtainTokenRequest($clientId, $grantType));
    }

    /**
     * Sets client secret field.
     */
    public function clientSecret(?string $value): self
    {
        $this->instance->setClientSecret($value);
        return $this;
    }

    /**
     * Unsets client secret field.
     */
    public function unsetClientSecret(): self
    {
        $this->instance->unsetClientSecret();
        return $this;
    }

    /**
     * Sets code field.
     */
    public function code(?string $value): self
    {
        $this->instance->setCode($value);
        return $this;
    }

    /**
     * Unsets code field.
     */
    public function unsetCode(): self
    {
        $this->instance->unsetCode();
        return $this;
    }

    /**
     * Sets redirect uri field.
     */
    public function redirectUri(?string $value): self
    {
        $this->instance->setRedirectUri($value);
        return $this;
    }

    /**
     * Unsets redirect uri field.
     */
    public function unsetRedirectUri(): self
    {
        $this->instance->unsetRedirectUri();
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
     * Unsets refresh token field.
     */
    public function unsetRefreshToken(): self
    {
        $this->instance->unsetRefreshToken();
        return $this;
    }

    /**
     * Sets migration token field.
     */
    public function migrationToken(?string $value): self
    {
        $this->instance->setMigrationToken($value);
        return $this;
    }

    /**
     * Unsets migration token field.
     */
    public function unsetMigrationToken(): self
    {
        $this->instance->unsetMigrationToken();
        return $this;
    }

    /**
     * Sets scopes field.
     */
    public function scopes(?array $value): self
    {
        $this->instance->setScopes($value);
        return $this;
    }

    /**
     * Unsets scopes field.
     */
    public function unsetScopes(): self
    {
        $this->instance->unsetScopes();
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
     * Unsets short lived field.
     */
    public function unsetShortLived(): self
    {
        $this->instance->unsetShortLived();
        return $this;
    }

    /**
     * Sets code verifier field.
     */
    public function codeVerifier(?string $value): self
    {
        $this->instance->setCodeVerifier($value);
        return $this;
    }

    /**
     * Unsets code verifier field.
     */
    public function unsetCodeVerifier(): self
    {
        $this->instance->unsetCodeVerifier();
        return $this;
    }

    /**
     * Initializes a new obtain token request object.
     */
    public function build(): ObtainTokenRequest
    {
        return CoreHelper::clone($this->instance);
    }
}
