<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\SubscriptionTestResult;

/**
 * Builder for model SubscriptionTestResult
 *
 * @see SubscriptionTestResult
 */
class SubscriptionTestResultBuilder
{
    /**
     * @var SubscriptionTestResult
     */
    private $instance;

    private function __construct(SubscriptionTestResult $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new subscription test result Builder object.
     */
    public static function init(): self
    {
        return new self(new SubscriptionTestResult());
    }

    /**
     * Sets id field.
     */
    public function id(?string $value): self
    {
        $this->instance->setId($value);
        return $this;
    }

    /**
     * Sets status code field.
     */
    public function statusCode(?int $value): self
    {
        $this->instance->setStatusCode($value);
        return $this;
    }

    /**
     * Unsets status code field.
     */
    public function unsetStatusCode(): self
    {
        $this->instance->unsetStatusCode();
        return $this;
    }

    /**
     * Sets payload field.
     */
    public function payload(?string $value): self
    {
        $this->instance->setPayload($value);
        return $this;
    }

    /**
     * Unsets payload field.
     */
    public function unsetPayload(): self
    {
        $this->instance->unsetPayload();
        return $this;
    }

    /**
     * Sets created at field.
     */
    public function createdAt(?string $value): self
    {
        $this->instance->setCreatedAt($value);
        return $this;
    }

    /**
     * Sets updated at field.
     */
    public function updatedAt(?string $value): self
    {
        $this->instance->setUpdatedAt($value);
        return $this;
    }

    /**
     * Initializes a new subscription test result object.
     */
    public function build(): SubscriptionTestResult
    {
        return CoreHelper::clone($this->instance);
    }
}
