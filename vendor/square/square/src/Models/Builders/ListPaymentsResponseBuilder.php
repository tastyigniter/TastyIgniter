<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\ListPaymentsResponse;

/**
 * Builder for model ListPaymentsResponse
 *
 * @see ListPaymentsResponse
 */
class ListPaymentsResponseBuilder
{
    /**
     * @var ListPaymentsResponse
     */
    private $instance;

    private function __construct(ListPaymentsResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new list payments response Builder object.
     */
    public static function init(): self
    {
        return new self(new ListPaymentsResponse());
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
     * Sets payments field.
     */
    public function payments(?array $value): self
    {
        $this->instance->setPayments($value);
        return $this;
    }

    /**
     * Sets cursor field.
     */
    public function cursor(?string $value): self
    {
        $this->instance->setCursor($value);
        return $this;
    }

    /**
     * Initializes a new list payments response object.
     */
    public function build(): ListPaymentsResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
