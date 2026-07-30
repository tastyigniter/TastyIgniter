<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\CreateTerminalCheckoutResponse;
use Square\Models\TerminalCheckout;

/**
 * Builder for model CreateTerminalCheckoutResponse
 *
 * @see CreateTerminalCheckoutResponse
 */
class CreateTerminalCheckoutResponseBuilder
{
    /**
     * @var CreateTerminalCheckoutResponse
     */
    private $instance;

    private function __construct(CreateTerminalCheckoutResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new create terminal checkout response Builder object.
     */
    public static function init(): self
    {
        return new self(new CreateTerminalCheckoutResponse());
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
     * Initializes a new create terminal checkout response object.
     */
    public function build(): CreateTerminalCheckoutResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
