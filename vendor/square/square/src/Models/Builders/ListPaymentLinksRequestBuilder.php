<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\ListPaymentLinksRequest;

/**
 * Builder for model ListPaymentLinksRequest
 *
 * @see ListPaymentLinksRequest
 */
class ListPaymentLinksRequestBuilder
{
    /**
     * @var ListPaymentLinksRequest
     */
    private $instance;

    private function __construct(ListPaymentLinksRequest $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new list payment links request Builder object.
     */
    public static function init(): self
    {
        return new self(new ListPaymentLinksRequest());
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
     * Unsets cursor field.
     */
    public function unsetCursor(): self
    {
        $this->instance->unsetCursor();
        return $this;
    }

    /**
     * Sets limit field.
     */
    public function limit(?int $value): self
    {
        $this->instance->setLimit($value);
        return $this;
    }

    /**
     * Unsets limit field.
     */
    public function unsetLimit(): self
    {
        $this->instance->unsetLimit();
        return $this;
    }

    /**
     * Initializes a new list payment links request object.
     */
    public function build(): ListPaymentLinksRequest
    {
        return CoreHelper::clone($this->instance);
    }
}
