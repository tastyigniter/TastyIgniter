<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\RetrieveTokenStatusResponse;

/**
 * Builder for model RetrieveTokenStatusResponse
 *
 * @see RetrieveTokenStatusResponse
 */
class RetrieveTokenStatusResponseBuilder
{
    /**
     * @var RetrieveTokenStatusResponse
     */
    private $instance;

    private function __construct(RetrieveTokenStatusResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new retrieve token status response Builder object.
     */
    public static function init(): self
    {
        return new self(new RetrieveTokenStatusResponse());
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
     * Sets expires at field.
     */
    public function expiresAt(?string $value): self
    {
        $this->instance->setExpiresAt($value);
        return $this;
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
     * Sets merchant id field.
     */
    public function merchantId(?string $value): self
    {
        $this->instance->setMerchantId($value);
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
     * Initializes a new retrieve token status response object.
     */
    public function build(): RetrieveTokenStatusResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
