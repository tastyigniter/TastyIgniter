<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\BulkRetrieveVendorsRequest;

/**
 * Builder for model BulkRetrieveVendorsRequest
 *
 * @see BulkRetrieveVendorsRequest
 */
class BulkRetrieveVendorsRequestBuilder
{
    /**
     * @var BulkRetrieveVendorsRequest
     */
    private $instance;

    private function __construct(BulkRetrieveVendorsRequest $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new bulk retrieve vendors request Builder object.
     */
    public static function init(): self
    {
        return new self(new BulkRetrieveVendorsRequest());
    }

    /**
     * Sets vendor ids field.
     */
    public function vendorIds(?array $value): self
    {
        $this->instance->setVendorIds($value);
        return $this;
    }

    /**
     * Unsets vendor ids field.
     */
    public function unsetVendorIds(): self
    {
        $this->instance->unsetVendorIds();
        return $this;
    }

    /**
     * Initializes a new bulk retrieve vendors request object.
     */
    public function build(): BulkRetrieveVendorsRequest
    {
        return CoreHelper::clone($this->instance);
    }
}
