<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\RenewTokenRequest;

/**
 * Builder for model RenewTokenRequest
 *
 * @see RenewTokenRequest
 */
class RenewTokenRequestBuilder
{
    /**
     * @var RenewTokenRequest
     */
    private $instance;

    private function __construct(RenewTokenRequest $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new renew token request Builder object.
     */
    public static function init(): self
    {
        return new self(new RenewTokenRequest());
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
     * Initializes a new renew token request object.
     */
    public function build(): RenewTokenRequest
    {
        return CoreHelper::clone($this->instance);
    }
}
