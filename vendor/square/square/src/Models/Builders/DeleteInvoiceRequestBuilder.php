<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\DeleteInvoiceRequest;

/**
 * Builder for model DeleteInvoiceRequest
 *
 * @see DeleteInvoiceRequest
 */
class DeleteInvoiceRequestBuilder
{
    /**
     * @var DeleteInvoiceRequest
     */
    private $instance;

    private function __construct(DeleteInvoiceRequest $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new delete invoice request Builder object.
     */
    public static function init(): self
    {
        return new self(new DeleteInvoiceRequest());
    }

    /**
     * Sets version field.
     */
    public function version(?int $value): self
    {
        $this->instance->setVersion($value);
        return $this;
    }

    /**
     * Initializes a new delete invoice request object.
     */
    public function build(): DeleteInvoiceRequest
    {
        return CoreHelper::clone($this->instance);
    }
}
