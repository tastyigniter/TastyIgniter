<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\BulkCreateVendorsRequest;

/**
 * Builder for model BulkCreateVendorsRequest
 *
 * @see BulkCreateVendorsRequest
 */
class BulkCreateVendorsRequestBuilder
{
    /**
     * @var BulkCreateVendorsRequest
     */
    private $instance;

    private function __construct(BulkCreateVendorsRequest $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new bulk create vendors request Builder object.
     */
    public static function init(array $vendors): self
    {
        return new self(new BulkCreateVendorsRequest($vendors));
    }

    /**
     * Initializes a new bulk create vendors request object.
     */
    public function build(): BulkCreateVendorsRequest
    {
        return CoreHelper::clone($this->instance);
    }
}
