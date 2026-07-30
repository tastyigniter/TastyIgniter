<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\BulkDeleteLocationCustomAttributesRequest;

/**
 * Builder for model BulkDeleteLocationCustomAttributesRequest
 *
 * @see BulkDeleteLocationCustomAttributesRequest
 */
class BulkDeleteLocationCustomAttributesRequestBuilder
{
    /**
     * @var BulkDeleteLocationCustomAttributesRequest
     */
    private $instance;

    private function __construct(BulkDeleteLocationCustomAttributesRequest $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new bulk delete location custom attributes request Builder object.
     */
    public static function init(array $values): self
    {
        return new self(new BulkDeleteLocationCustomAttributesRequest($values));
    }

    /**
     * Initializes a new bulk delete location custom attributes request object.
     */
    public function build(): BulkDeleteLocationCustomAttributesRequest
    {
        return CoreHelper::clone($this->instance);
    }
}
