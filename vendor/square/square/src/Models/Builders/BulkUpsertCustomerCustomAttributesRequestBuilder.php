<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\BulkUpsertCustomerCustomAttributesRequest;

/**
 * Builder for model BulkUpsertCustomerCustomAttributesRequest
 *
 * @see BulkUpsertCustomerCustomAttributesRequest
 */
class BulkUpsertCustomerCustomAttributesRequestBuilder
{
    /**
     * @var BulkUpsertCustomerCustomAttributesRequest
     */
    private $instance;

    private function __construct(BulkUpsertCustomerCustomAttributesRequest $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new bulk upsert customer custom attributes request Builder object.
     */
    public static function init(array $values): self
    {
        return new self(new BulkUpsertCustomerCustomAttributesRequest($values));
    }

    /**
     * Initializes a new bulk upsert customer custom attributes request object.
     */
    public function build(): BulkUpsertCustomerCustomAttributesRequest
    {
        return CoreHelper::clone($this->instance);
    }
}
