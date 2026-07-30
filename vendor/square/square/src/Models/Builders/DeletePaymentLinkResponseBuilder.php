<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\DeletePaymentLinkResponse;

/**
 * Builder for model DeletePaymentLinkResponse
 *
 * @see DeletePaymentLinkResponse
 */
class DeletePaymentLinkResponseBuilder
{
    /**
     * @var DeletePaymentLinkResponse
     */
    private $instance;

    private function __construct(DeletePaymentLinkResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new delete payment link response Builder object.
     */
    public static function init(): self
    {
        return new self(new DeletePaymentLinkResponse());
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
     * Sets id field.
     */
    public function id(?string $value): self
    {
        $this->instance->setId($value);
        return $this;
    }

    /**
     * Sets cancelled order id field.
     */
    public function cancelledOrderId(?string $value): self
    {
        $this->instance->setCancelledOrderId($value);
        return $this;
    }

    /**
     * Initializes a new delete payment link response object.
     */
    public function build(): DeletePaymentLinkResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
