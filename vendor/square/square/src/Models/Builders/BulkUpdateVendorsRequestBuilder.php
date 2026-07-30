<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\BulkUpdateVendorsRequest;

/**
 * Builder for model BulkUpdateVendorsRequest
 *
 * @see BulkUpdateVendorsRequest
 */
class BulkUpdateVendorsRequestBuilder
{
    /**
     * @var BulkUpdateVendorsRequest
     */
    private $instance;

    private function __construct(BulkUpdateVendorsRequest $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new bulk update vendors request Builder object.
     */
    public static function init(array $vendors): self
    {
        return new self(new BulkUpdateVendorsRequest($vendors));
    }

    /**
     * Initializes a new bulk update vendors request object.
     */
    public function build(): BulkUpdateVendorsRequest
    {
        return CoreHelper::clone($this->instance);
    }
}
