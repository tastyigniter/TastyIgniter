<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\RegisterDomainResponse;

/**
 * Builder for model RegisterDomainResponse
 *
 * @see RegisterDomainResponse
 */
class RegisterDomainResponseBuilder
{
    /**
     * @var RegisterDomainResponse
     */
    private $instance;

    private function __construct(RegisterDomainResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new register domain response Builder object.
     */
    public static function init(): self
    {
        return new self(new RegisterDomainResponse());
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
     * Sets status field.
     */
    public function status(?string $value): self
    {
        $this->instance->setStatus($value);
        return $this;
    }

    /**
     * Initializes a new register domain response object.
     */
    public function build(): RegisterDomainResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
