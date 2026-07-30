<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\RevokeTokenResponse;

/**
 * Builder for model RevokeTokenResponse
 *
 * @see RevokeTokenResponse
 */
class RevokeTokenResponseBuilder
{
    /**
     * @var RevokeTokenResponse
     */
    private $instance;

    private function __construct(RevokeTokenResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new revoke token response Builder object.
     */
    public static function init(): self
    {
        return new self(new RevokeTokenResponse());
    }

    /**
     * Sets success field.
     */
    public function success(?bool $value): self
    {
        $this->instance->setSuccess($value);
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
     * Initializes a new revoke token response object.
     */
    public function build(): RevokeTokenResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
