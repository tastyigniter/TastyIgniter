<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\ListPaymentLinksResponse;

/**
 * Builder for model ListPaymentLinksResponse
 *
 * @see ListPaymentLinksResponse
 */
class ListPaymentLinksResponseBuilder
{
    /**
     * @var ListPaymentLinksResponse
     */
    private $instance;

    private function __construct(ListPaymentLinksResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new list payment links response Builder object.
     */
    public static function init(): self
    {
        return new self(new ListPaymentLinksResponse());
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
     * Sets payment links field.
     */
    public function paymentLinks(?array $value): self
    {
        $this->instance->setPaymentLinks($value);
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
     * Initializes a new list payment links response object.
     */
    public function build(): ListPaymentLinksResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
