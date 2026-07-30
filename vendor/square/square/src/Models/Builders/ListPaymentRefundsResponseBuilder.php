<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\ListPaymentRefundsResponse;

/**
 * Builder for model ListPaymentRefundsResponse
 *
 * @see ListPaymentRefundsResponse
 */
class ListPaymentRefundsResponseBuilder
{
    /**
     * @var ListPaymentRefundsResponse
     */
    private $instance;

    private function __construct(ListPaymentRefundsResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new list payment refunds response Builder object.
     */
    public static function init(): self
    {
        return new self(new ListPaymentRefundsResponse());
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
     * Sets refunds field.
     */
    public function refunds(?array $value): self
    {
        $this->instance->setRefunds($value);
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
     * Initializes a new list payment refunds response object.
     */
    public function build(): ListPaymentRefundsResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
