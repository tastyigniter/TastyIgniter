<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\BulkDeleteOrderCustomAttributesRequest;

/**
 * Builder for model BulkDeleteOrderCustomAttributesRequest
 *
 * @see BulkDeleteOrderCustomAttributesRequest
 */
class BulkDeleteOrderCustomAttributesRequestBuilder
{
    /**
     * @var BulkDeleteOrderCustomAttributesRequest
     */
    private $instance;

    private function __construct(BulkDeleteOrderCustomAttributesRequest $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new bulk delete order custom attributes request Builder object.
     */
    public static function init(array $values): self
    {
        return new self(new BulkDeleteOrderCustomAttributesRequest($values));
    }

    /**
     * Initializes a new bulk delete order custom attributes request object.
     */
    public function build(): BulkDeleteOrderCustomAttributesRequest
    {
        return CoreHelper::clone($this->instance);
    }
}
