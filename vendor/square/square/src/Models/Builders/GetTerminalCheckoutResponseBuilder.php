<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\GetTerminalCheckoutResponse;
use Square\Models\TerminalCheckout;

/**
 * Builder for model GetTerminalCheckoutResponse
 *
 * @see GetTerminalCheckoutResponse
 */
class GetTerminalCheckoutResponseBuilder
{
    /**
     * @var GetTerminalCheckoutResponse
     */
    private $instance;

    private function __construct(GetTerminalCheckoutResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new get terminal checkout response Builder object.
     */
    public static function init(): self
    {
        return new self(new GetTerminalCheckoutResponse());
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
     * Sets checkout field.
     */
    public function checkout(?TerminalCheckout $value): self
    {
        $this->instance->setCheckout($value);
        return $this;
    }

    /**
     * Initializes a new get terminal checkout response object.
     */
    public function build(): GetTerminalCheckoutResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
