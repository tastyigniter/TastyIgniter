<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\CompletePaymentRequest;

/**
 * Builder for model CompletePaymentRequest
 *
 * @see CompletePaymentRequest
 */
class CompletePaymentRequestBuilder
{
    /**
     * @var CompletePaymentRequest
     */
    private $instance;

    private function __construct(CompletePaymentRequest $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new complete payment request Builder object.
     */
    public static function init(): self
    {
        return new self(new CompletePaymentRequest());
    }

    /**
     * Sets version token field.
     */
    public function versionToken(?string $value): self
    {
        $this->instance->setVersionToken($value);
        return $this;
    }

    /**
     * Unsets version token field.
     */
    public function unsetVersionToken(): self
    {
        $this->instance->unsetVersionToken();
        return $this;
    }

    /**
     * Initializes a new complete payment request object.
     */
    public function build(): CompletePaymentRequest
    {
        return CoreHelper::clone($this->instance);
    }
}
