<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\CancelInvoiceRequest;

/**
 * Builder for model CancelInvoiceRequest
 *
 * @see CancelInvoiceRequest
 */
class CancelInvoiceRequestBuilder
{
    /**
     * @var CancelInvoiceRequest
     */
    private $instance;

    private function __construct(CancelInvoiceRequest $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new cancel invoice request Builder object.
     */
    public static function init(int $version): self
    {
        return new self(new CancelInvoiceRequest($version));
    }

    /**
     * Initializes a new cancel invoice request object.
     */
    public function build(): CancelInvoiceRequest
    {
        return CoreHelper::clone($this->instance);
    }
}
