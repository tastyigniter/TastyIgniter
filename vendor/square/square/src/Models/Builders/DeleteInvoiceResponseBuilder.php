<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\DeleteInvoiceResponse;

/**
 * Builder for model DeleteInvoiceResponse
 *
 * @see DeleteInvoiceResponse
 */
class DeleteInvoiceResponseBuilder
{
    /**
     * @var DeleteInvoiceResponse
     */
    private $instance;

    private function __construct(DeleteInvoiceResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new delete invoice response Builder object.
     */
    public static function init(): self
    {
        return new self(new DeleteInvoiceResponse());
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
     * Initializes a new delete invoice response object.
     */
    public function build(): DeleteInvoiceResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
