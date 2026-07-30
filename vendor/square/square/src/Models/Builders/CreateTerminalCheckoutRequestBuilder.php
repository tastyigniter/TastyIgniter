<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\CreateTerminalCheckoutRequest;
use Square\Models\TerminalCheckout;

/**
 * Builder for model CreateTerminalCheckoutRequest
 *
 * @see CreateTerminalCheckoutRequest
 */
class CreateTerminalCheckoutRequestBuilder
{
    /**
     * @var CreateTerminalCheckoutRequest
     */
    private $instance;

    private function __construct(CreateTerminalCheckoutRequest $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new create terminal checkout request Builder object.
     */
    public static function init(string $idempotencyKey, TerminalCheckout $checkout): self
    {
        return new self(new CreateTerminalCheckoutRequest($idempotencyKey, $checkout));
    }

    /**
     * Initializes a new create terminal checkout request object.
     */
    public function build(): CreateTerminalCheckoutRequest
    {
        return CoreHelper::clone($this->instance);
    }
}
