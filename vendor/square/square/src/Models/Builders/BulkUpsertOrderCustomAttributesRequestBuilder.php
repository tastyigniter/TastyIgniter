<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\BulkUpsertOrderCustomAttributesRequest;

/**
 * Builder for model BulkUpsertOrderCustomAttributesRequest
 *
 * @see BulkUpsertOrderCustomAttributesRequest
 */
class BulkUpsertOrderCustomAttributesRequestBuilder
{
    /**
     * @var BulkUpsertOrderCustomAttributesRequest
     */
    private $instance;

    private function __construct(BulkUpsertOrderCustomAttributesRequest $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new bulk upsert order custom attributes request Builder object.
     */
    public static function init(array $values): self
    {
        return new self(new BulkUpsertOrderCustomAttributesRequest($values));
    }

    /**
     * Initializes a new bulk upsert order custom attributes request object.
     */
    public function build(): BulkUpsertOrderCustomAttributesRequest
    {
        return CoreHelper::clone($this->instance);
    }
}
